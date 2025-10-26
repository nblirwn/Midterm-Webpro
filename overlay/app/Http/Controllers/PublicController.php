<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function show($token)
    {
        $note = Note::with('category')->where('share_token',$token)->where('is_archived',false)->first();
        abort_if(!$note, 404);
        return view('public.show', compact('note'));
    }
}
