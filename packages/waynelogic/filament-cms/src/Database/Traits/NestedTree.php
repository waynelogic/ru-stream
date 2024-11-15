<?php namespace Waynelogic\FilamentCms\Database\Traits;

trait NestedTree
{
    public static function bootNestedTree()
    {
        static::creating(function ($model) {
            if (!$model->parent_id) {
                $model->nest_left = 1;
                $model->nest_right = 2;
                $model->nest_depth = 0;
            } else {
                $parent = static::findOrFail($model->parent_id);
                $model->nest_left = $parent->nest_right;
                $model->nest_right = $parent->nest_right + 1;
                $model->nest_depth = $parent->nest_depth + 1;
                static::where('nest_right', '>=', $parent->nest_right)
                    ->increment('nest_right', 2);
                static::where('nest_left', '>', $parent->nest_right)
                    ->increment('nest_left', 2);
                $parent->nest_right += 2;
                $parent->save();
            }
        });

        static::deleting(function ($model) {
            $diff = $model->nest_right - $model->nest_left + 1;
            static::where('nest_left', '>', $model->nest_left)
                ->decrement('nest_left', $diff);
            static::where('nest_right', '>', $model->nest_right)
                ->decrement('nest_right', $diff);
        });
    }

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    public function descendants()
    {
        return static::where('nest_left', '>', $this->nest_left)
            ->where('nest_right', '<', $this->nest_right)
            ->orderBy('nest_left');
    }

    public function ancestors()
    {
        return static::where('nest_left', '<', $this->nest_left)
            ->where('nest_right', '>', $this->nest_right)
            ->orderBy('nest_left');
    }

    public function scopeRoots(Builder $query)
    {
        return $query->whereNull('parent_id');
    }

    public function getLevel()
    {
        return $this->nest_depth;
    }

    public function isRoot()
    {
        return $this->parent_id === null;
    }

    public function isLeaf()
    {
        return $this->nest_right - $this->nest_left === 1;
    }

    public function getDescendantsAndSelf(): Collection
    {
        return static::where('nest_left', '>=', $this->nest_left)
            ->where('nest_right', '<=', $this->nest_right)
            ->orderBy('nest_left')
            ->get();
    }

    public function scopeWhereDescendantOf(Builder $query, self $node)
    {
        return $query->where('nest_left', '>', $node->nest_left)
            ->where('nest_right', '<', $node->nest_right);
    }

    public function moveToParent($newParent)
    {
        $this->parent_id = $newParent ? $newParent->id : null;
        $this->save();
        $this->rebuildTree();
    }

    protected function rebuildTree($parentId = null, $left = 1, $depth = 0)
    {
        $right = $left + 1;
        $children = static::where('parent_id', $parentId)->get();

        foreach ($children as $child) {
            $right = $child->rebuildTree($child->id, $right, $depth + 1);
        }

        if ($parentId !== null) {
            static::where('id', $parentId)->update([
                'nest_left' => $left,
                'nest_right' => $right,
                'nest_depth' => $depth
            ]);
        }

        return $right + 1;
    }
}
