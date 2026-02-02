<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class Post extends Model
{
    // Lista pól, które będziemy wypełniać w formularzu 
    protected $fillable = ['title', 'content', 'category_id', 'slug', 'status'];

    // Relacja: Post należy do jednej Kategorii 
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}