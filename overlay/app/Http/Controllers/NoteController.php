<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $q = $request->get('q');
        $cat = $request->get('cat');
        $tag = $request->get('tag');
        $archived = $request->boolean('archived');

        $notes = Note::with('category', 'tags')
            ->where('user_id', $user->id)
            ->when($archived, fn($w)=>$w->where('is_archived', true))
            ->when(!$archived, fn($w)=>$w->where('is_archived', false))
            ->when($q, fn($w)=>$w->where(function($x) use ($q) {
                $x->where('title', 'like', "%$q%")->orWhere('content','like',"%$q%");
            }))
            ->when($cat, fn($w)=>$w->where('category_id',$cat))
            ->when($tag, fn($w)=>$w->whereHas('tags', fn($t)=>$t->where('name',$tag)))
            ->orderByDesc('is_pinned')->orderByDesc('updated_at')
            ->get();

        $categories = Category::where('user_id',$user->id)->orderBy('name')->get();

        return view('notes.index', compact('notes','categories','q','cat','tag','archived'));
    }

    public function create(Request $request)
    {
        $categories = Category::where('user_id',$request->user()->id)->orderBy('name')->get();
        return view('notes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['nullable','string','max:255'],
            'content' => ['nullable','string'],
            'category_id' => ['nullable','integer','exists:categories,id'],
            'tags' => ['nullable','string'],
        ]);

        $data['user_id'] = $request->user()->id;
        $note = Note::create($data);

        $this->syncTags($request, $note, $request->input('tags'));

        return redirect()->route('notes.index');
    }

    public function show(Note $note)
    {
        $this->authorizeNote($note);
        $note->load('category','tags');
        return view('notes.show', compact('note'));
    }

    public function edit(Request $request, Note $note)
    {
        $this->authorizeNote($note);
        $categories = Category::where('user_id',$request->user()->id)->orderBy('name')->get();
        $tags = $note->tags->pluck('name')->implode(',');
        return view('notes.edit', compact('note','categories','tags'));
    }

    public function update(Request $request, Note $note)
    {
        $this->authorizeNote($note);
        $data = $request->validate([
            'title' => ['nullable','string','max:255'],
            'content' => ['nullable','string'],
            'category_id' => ['nullable','integer','exists:categories,id'],
            'tags' => ['nullable','string'],
        ]);
        $note->update($data);
        $this->syncTags($request, $note, $request->input('tags'));
        return redirect()->route('notes.index');
    }

    public function destroy(Note $note)
    {
        $this->authorizeNote($note);
        $note->delete();
        return redirect()->route('notes.index');
    }

    public function togglePin(Note $note)
    {
        $this->authorizeNote($note);
        $note->is_pinned = !$note->is_pinned;
        $note->save();
        return back();
    }

    public function archive(Note $note)
    {
        $this->authorizeNote($note);
        $note->is_archived = true;
        $note->save();
        return back();
    }

    public function restore(Note $note)
    {
        $this->authorizeNote($note);
        $note->is_archived = false;
        $note->save();
        return back()->with('status','Restored');
    }

    public function share(Note $note)
    {
        $this->authorizeNote($note);
        $note->share_token = Str::random(20);
        $note->save();
        return back()->with('status','Share link dibuat: '.route('public.note',$note->share_token));
    }

    public function unshare(Note $note)
    {
        $this->authorizeNote($note);
        $note->share_token = null;
        $note->save();
        return back();
    }

    private function syncTags(Request $request, Note $note, $tagsCsv)
    {
        $user_id = $request->user()->id;
        $names = collect(explode(',', (string)$tagsCsv))
            ->map(fn($x)=>trim($x))
            ->filter()
            ->unique();

        $tagIds = [];
        foreach ($names as $name) {
            $tag = Tag::firstOrCreate(['user_id'=>$user_id,'name'=>$name]);
            $tagIds[] = $tag->id;
        }
        $note->tags()->sync($tagIds);
    }

    private function authorizeNote(Note $note)
    {
        abort_if($note->user_id !== auth()->id(), 403);
    }
}
