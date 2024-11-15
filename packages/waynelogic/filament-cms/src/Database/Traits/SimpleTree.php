<?php

namespace Waynelogic\FilamentCms\Database\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * $table->foreignId('parent_id')->nullable()->constrained('TABLE NAME')->nullOnDelete();
 */
trait SimpleTree
{
    public function initializeSimpleTree()
    {
//        // Define relationships
//        $this->hasMany['children'] = [
//            static::class,
//            'key' => $this->getParentColumnName(),
//            'replicate' => false
//        ];
//
//        $this->belongsTo['parent'] = [
//            static::class,
//            'key' => $this->getParentColumnName(),
//            'replicate' => false
//        ];
    }

    public function children(): HasMany
    {
        return $this->hasMany(static::class,  $this->getParentColumnName());
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class,  $this->getParentColumnName());
    }

    public function getAll()
    {
        $collection = [];
        foreach ($this->getAllRoot() as $rootNode) {
            $collection[] = $rootNode;
            $collection = $collection + $rootNode->getAllChildren()->getDictionary();
        }

        return new Collection($collection);
    }

    public function getParentColumnName()
    {
        return defined('static::PARENT_ID') ? static::PARENT_ID : 'parent_id';
    }
}
