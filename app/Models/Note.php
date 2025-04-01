<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /** @use HasFactory<\Database\Factories\NotesFactory> */
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
