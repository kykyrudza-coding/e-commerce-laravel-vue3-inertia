<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
        'slug'
    ];
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }
}
