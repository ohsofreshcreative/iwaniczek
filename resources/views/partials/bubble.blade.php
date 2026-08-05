@php
    $active         = get_field('active', 'option');
    $image          = get_field('image', 'option');
    $heading        = get_field('heading', 'option');
    $text           = get_field('text', 'option');
    $button         = get_field('button', 'option');
    $collapsed_text = get_field('collapsed_text', 'option');
@endphp

@if ($active)
<div
    x-data="{ collapsed: sessionStorage.getItem('bubbleCollapsed') === '1' }"
    role="complementary"
    aria-label="Dymek informacyjny"
>
    {{-- Karta rozwinięta --}}
    <div
        class="fixed bottom-7 right-7 z-99 max-sm:bottom-4 max-sm:right-4 bg-primary rounded-2xl shadow-[0_8px_40px_rgba(0,0,0,0.18)] w-[300px] max-[400px]:w-[calc(100vw-2rem)] overflow-hidden flex flex-col origin-bottom-right"
        x-show="!collapsed"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
    >
        <button
            class="absolute top-2.5 right-2.5 bg-secondary-900 border-0 rounded-full w-8 h-8 flex items-center justify-center cursor-pointer z-[2] hover:bg-secondary-400 transition-colors"
            @click="collapsed = true; sessionStorage.setItem('bubbleCollapsed', '1')"
            aria-label="Zwiń dymek"
            type="button"
        >
            <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>

        @if ($image)
            <div class="w-full h-40 overflow-hidden shrink-0">
                <img
                    class="w-full h-full object-cover block"
                    src="{{ $image['url'] }}"
                    alt="{{ $image['alt'] ?: $heading }}"
                    width="{{ $image['width'] ?? '' }}"
                    height="{{ $image['height'] ?? '' }}"
                    loading="lazy"
                >
            </div>
        @endif

        <div class="px-5 pt-[18px] pb-[22px] flex flex-col gap-2.5">
            @if ($heading)
                <h5 class="font-bold m-0 leading-tight">{{ $heading }}</h5>
            @endif

            @if ($text)
                <p class="!text-secondary !font-medium m-0">{{ $text }}</p>
            @endif

            @if ($button)
                <a
                    href="{{ $button['url'] }}"
                    class="inline-block bg-secondary text-white text-sm font-semibold py-4 px-5 rounded-lg no-underline text-center mt-1 hover:bg-secondary-400 transition-colors"
                    target="{{ $button['target'] ?: '_self' }}"
                    rel="{{ $button['target'] === '_blank' ? 'noopener noreferrer' : '' }}"
                >
                    {{ $button['title'] }}
                </a>
            @endif
        </div>
    </div>

    {{-- Przycisk zwinięty --}}
    <button
        class="fixed bottom-7 right-7 z-10 max-sm:bottom-4 max-sm:right-4 flex items-center gap-2.5 bg-primary text-secondary border-0 rounded-full py-3 px-5 cursor-pointer shadow-[0_4px_20px_rgba(0,0,0,0.2)] text-base font-medium hover:bg-primary-hover transition-colors max-w-[280px] origin-bottom-right"
        x-show="collapsed"
        x-transition:enter="transition ease-out duration-300 delay-[200ms]"
        x-transition:enter-start="opacity-0 scale-75"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-75"
        @click="collapsed = false; sessionStorage.removeItem('bubbleCollapsed')"
        type="button"
        aria-label="Rozwiń dymek"
    >
        @if ($collapsed_text)
            <span class="flex-1 text-left !font-medium leading-tight">{{ $collapsed_text }}</span>
        @endif
        <svg class="w-[22px] h-[22px] shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
        </svg>
    </button>
</div>
@endif
