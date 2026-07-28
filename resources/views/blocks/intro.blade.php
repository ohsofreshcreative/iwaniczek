<!--- intro -->

<section
    data-gsap-anim="section"
    @if(!empty($section_id)) id="{{ $section_id }}" @endif
    @class([
        'b-intro relative -spt  overflow-hidden ',
        $sectionClass => filled($sectionClass),
        $section_class => filled($section_class),
        $background => filled($background) && $background !== 'none',
    ])>

    <div class="__wrapper c-main relative z-1">
<div class="__col grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-14 items-stretch">

    @if (!empty($g_intro['image']))
        <div data-gsap-element="img" class="__img order1 self-start ">
            <img
                class="w-full h-full object-cover max-h-160"
                src="{{ $g_intro['image']['url'] }}"
                alt="{{ $g_intro['image']['alt'] ?? '' }}">
        </div>
    @endif

    <div class="__intro order2 flex flex-col justify-between h-full items-start">

        <div class="__content">
            <h2 data-gsap-element="header" class="header-line">
                {{ $g_intro['header'] }}
            </h2>

            <div data-gsap-element="txt" class="__txt mt-4">
                {!! $g_intro['text'] !!}
            </div>

            <div class="inline-buttons m-btn">
                @if (!empty($g_intro['button1']))
                    <x-button
                        :href="$g_intro['button1']['url']"
                        variant=""
                        class="btn-outline-primary"
                        data-gsap-element="btn">
                        {{ $g_intro['button1']['title'] }}
                    </x-button>
                @endif

                @if (!empty($g_intro['button2']))
                    <x-button
                        :href="$g_intro['button2']['url']"
                        variant="secondary"
                        class=""
                        data-gsap-element="btn">
                        {{ $g_intro['button2']['title'] }}
                    </x-button>
                @endif
            </div>
        </div>


        @if (!empty($g_intro['r_intro']))
            <div class="__features  space-y-4" data-gsap-element="features">
                @foreach ($g_intro['r_intro'] as $item)
                    @if (!empty($item['title']))
                        <div class="flex items-center gap-4">
                            @if (!empty($item['number']))
                                <span class="text-xl text-secondary-400 font-semibold font-header">
                                    {{ $item['number'] }}
                                </span>
                            @endif

                            <p class="font-semibold text-h6">
                                {{ $item['title'] }}
                            </p>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

    </div>

</div>
    </div>
@if(!is_page('o-nas') && !is_page('about'))
<img src="/wp-content/uploads/2026/07/header.png" class="absolute inset-0 z-0 w-full " />
@endif
</section>