<?php namespace Waynelogic\FilamentBlog\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $table = 'blog_posts';

    protected $casts = [
        'published_at' => 'date',
        'active' => 'boolean',
    ];

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

//    public function getUrlAttribute() : string
//    {
//        return route('blog.show', $this->slug);
//    }

    public function scopeActive(Builder $query): void
    {
        $query->where('active', true)->where('published_at', '<=', now());
    }
}
