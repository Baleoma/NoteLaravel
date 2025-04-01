<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /** @use HasFactory<\Database\Factories\NoteFactory> */
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function tag() {
        return $this->belongsToMany(Tag::class, 'note_tags');
    }
}
