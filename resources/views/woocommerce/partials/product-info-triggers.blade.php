<div class="product-info-items">
    <div class="product-info-items__list">
        @foreach ($items as $item)
            <button
                class="product-info-item-trigger"
                type="button"
                onclick="window.dispatchEvent(new CustomEvent('product-drawer-open', { detail: {{ \Illuminate\Support\Js::from($item) }} }))">
                {{ $item['title'] }}
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        @endforeach
    </div>
</div>
