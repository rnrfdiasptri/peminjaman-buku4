<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'author', 'publisher', 'year', 'stock'];
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
