<?php

namespace Waynelogic\FilamentCms\Cms;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Waynelogic\FilamentCms\Database\Traits\Singleton;

class SettingsManager
{
    /**
     * @var Collection of registered items
     */
    protected ?Collection $items = null;

    /**
     * @var array groupedItems by category
     */
    protected $groupedItems;

    /**
     * @var string contextOwner is the active plugin or module owner.
     */
    protected $contextOwner;

    /**
     * @var string contextItemCode for active item
     */
    protected $contextItemCode;

    use Singleton;

    public function listItems($context = null)
    {
        if ($this->items === null) {
            $this->loadItems();
        }
        $this->groupedItems = $this->items->groupBy('category');

        return $this->groupedItems;
    }

    private function loadItems() : void
    {
        $arEvents = Event::dispatch('cms.register.navigation');
        $arItems = array_merge(...$arEvents);

        $this->items = collect($arItems)->sortBy('order');

    }

    public function findSettingItem($code)
    {
        if ($this->items === null) $this->loadItems();

        return $this->items->where('code', $code)->first();
    }
}
