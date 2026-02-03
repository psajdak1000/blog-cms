<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'category_id', 'slug', 'status'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value ? 'published' : 'draft';
    }

    public function getStatusAttribute($value)
    {
        return $value === 'published';
    }
}