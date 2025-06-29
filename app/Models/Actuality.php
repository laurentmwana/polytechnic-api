<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actuality extends Model
{
    /** @use HasFactory<\Database\Factories\ActualityFactory> */
    use HasFactory;

    protected $fillable = ['title', 'description'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
