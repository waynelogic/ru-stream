<?php namespace Waynelogic\FilamentBlog\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'blog_categories';
    protected $casts = [
        'active' => 'boolean',
    ];

    public function posts() : HasMany
    {
        return $this->hasMany(Post::class);
    }
}
