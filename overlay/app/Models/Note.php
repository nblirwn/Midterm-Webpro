<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Note extends Model
{
    protected $fillable = [
        'user_id','category_id','title','content','is_pinned','is_archived','share_token'
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_archived' => 'boolean',
    ];

    public function user(): BelongsTo 
    { 
        return $this->belongsTo(User::class); 
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class); 
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'note_tag');
    }
}
