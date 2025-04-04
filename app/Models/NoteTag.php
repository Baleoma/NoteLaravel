<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteTag extends Model
{
    protected $fillable = ['note_id', 'tag_id'];

    /** @use HasFactory<\Database\Factories\NoteTagFactory> */
    use HasFactory;
}
