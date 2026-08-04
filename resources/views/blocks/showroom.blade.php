@php
$sectionClass = '';
$sectionClass .= $flip ? ' order-flip' : '';
$sectionClass .= $nolist ? ' no-list' : '';
$sectionClass .= $wide ? ' wide' : '';
$sectionClass .= $nomt ? ' !mt-0' : '';
$sectionClass .= $gap ? ' wider-gap' : '';

if (!empty($background) && $background !== 'none') {
    $sectionClass .= ' ' . $background;
}
@endphp

<!--- showroom --->

<section 
    data-gsap-anim="section"
    @if(!empty($section_id)) id="{{ $section_id }}" @endif
    class="b-showroom relative -smt {{ $sectionClass }} {{ $section_class }}"
>

    @if(!empty($g_showroom['title']) || !empty($g_showroom['text']))
        <div class="__wrapper c-main block relative z-20">

            @if(!empty($g_showroom['title']))
                <h2 class="header-line">
                    {{ $g_showroom['title'] }}
                </h2>
            @endif

            @if(!empty($g_showroom['text']))
                <div class="__text text-white text-[15px] mt-6">
                    {!! $g_showroom['text'] !!}
                </div>
            @endif

        </div>
    @endif


    <div class="c-main">

        <div class="showroom-slider-wrapper relative z-20 mt-12">

            <div class="swiper showroom-standard">

                <div class="swiper-wrapper">

                    @foreach($showroom as $slide)

                        <div class="swiper-slide">

                            @if(($slide['type'] ?? 'image') === 'video')

                                @php
                                    preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $slide['video_url'] ?? '', $yt);
                                    $yt_id = $yt[1] ?? '';
                                @endphp
                                @if($yt_id)
                                    <button
                                        type="button"
                                        class="yt-thumb-trigger w-full h-full relative cursor-pointer group"
                                        data-yt-id="{{ $yt_id }}"
                                    >
                                        <img
                                            src="https://img.youtube.com/vi/{{ $yt_id }}/maxresdefault.jpg"
                                            onerror="this.src='https://img.youtube.com/vi/{{ $yt_id }}/hqdefault.jpg'"
                                            alt=""
                                            class="w-full h-full object-cover"
                                        >
                                        <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/40 transition-colors duration-300">
                                            <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center transition-transform duration-300 group-hover:scale-110">
                                                <svg class="w-6 h-6 text-white translate-x-0.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </button>
                                @endif

                            @else

                                @if(!empty($slide['image']))
                                    <img
                                        src="{{ $slide['image']['url'] }}"
                                        alt="{{ $slide['image']['alt'] ?? '' }}"
                                        class="w-full h-full object-cover"
                                    >
                                @endif

                            @endif

                        </div>

                    @endforeach

                </div>

            </div>


            <div class="showroom-navigation flex gap-4 mt-7">

                <button 
                    class="showroom-prev bg-primary h-16 w-16 flex items-center justify-center cursor-pointer transition-all duration-400"
                >
                    <x-icon.arrow-left class="__arrow text-black w-4 h-auto overflow-visible" />
                </button>


                <button 
                    class="showroom-next bg-primary h-16 w-16 flex items-center justify-center cursor-pointer transition-all duration-400"
                >
                    <x-icon.arrow-right class="__arrow text-black w-4 h-auto overflow-visible" />
                </button>

            </div>


        </div>

    </div>

</section>