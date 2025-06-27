<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actuality extends Model
{
    /** @use HasFactory<\Database\Factories\ActualityFactory> */
    use HasFactory;

    protected $fillable = ['title', 'description'];

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
