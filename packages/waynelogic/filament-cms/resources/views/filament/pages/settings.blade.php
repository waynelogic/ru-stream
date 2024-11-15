<x-filament-panels::page>
@foreach($this->arGroups as $obGroup => $arItems)
    <div class="settings-group">
        <h3 class="settings-group-title">{{ $obGroup }}</h3>
        <ul class="settings-group-list">
            @foreach($arItems as $obItem)
                <li>
                    <a class="settings-item" href="{{ $obItem->url }}">
                        @isset($obItem->icon)
                            @svg($obItem->icon, ['class' => 'settings-item-icon'])
                        @endisset
                        <div class="settings-item-content">
                            <span class="title">{{ $obItem->label }}</span>
                            <span class="description">{{ $obItem->description }}</span>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endforeach

<style>
    .settings-group-title {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 15px;
    }
    .settings-group-list {
        align-content: stretch;
        align-items: stretch;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: 20px;
    }
    .settings-item {
        display: flex;
        background: white;
        height: 100%;
        min-height: 100px;
        min-width: 350px;
        width: 100%;
        overflow: hidden;
        padding: 15px;
        border-radius: 15px;
        box-shadow: rgba(100, 100, 111, 0.1) 0 7px 15px 0;
        border: 1px solid #d8d7d7;
        transition: all 0.3s ease;
        &:hover {
            color: white;
            background: rgba(var(--primary-600),var(--tw-text-opacity))
        }
        .settings-item-content {
            display: flex;
            flex-direction: column;
            .title {
                font-weight: bold;
                font-size: 18px;
            }
        }
    }
    .settings-item-icon {
        width: 50px;
        height: 50px;
        margin-right: 15px;
    }
</style>

</x-filament-panels::page>
