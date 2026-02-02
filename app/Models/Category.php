<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; 

class Category extends Model
{
    // To pozwala na bezpieczne zapisywanie nazwy i sluga 
    protected $fillable = ['name', 'slug'];

    // To mówi, że kategoria ma wiele postów 
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}