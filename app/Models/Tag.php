<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;

    public function note() {
        return $this->belongsToMany(Note::class, 'note_tags');
    }
}
