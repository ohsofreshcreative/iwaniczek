<!-- hero --->
<section
    data-gsap-anim="section"
    @if(!empty($section_id)) id="{{ $section_id }}" @endif
    @class([ 
        'b-hero relative overflow-hidden bg-[#18191B]',
        $sectionClass => filled($sectionClass),
        $section_class => filled($section_class),
    ])
>
<!-- <img src="/wp-content/uploads/2026/07/header.png" class="absolute inset-0 z-20 w-full object-cover top-0 left-0 rotate-45" /> -->

    @if(!empty($g_hero['image']['url']))
    <div 
        class="absolute inset-0 bg-cover bg-center bg-no-repeat z-0"
        style="background-image: url('{{ $g_hero['image']['url'] }}');">
    </div>
    @endif

    <div 
        class="absolute top-0 left-0 w-full h-[40vw] min-h-[250px] bg-top bg-cover bg-no-repeat z-10 pointer-events-none"
        style="background-image: url('/wp-content/uploads/2026/07/bg.png');">
    </div>


    <div class="__wrapper c-main flex flex-col-reverse md:grid md:grid-cols-2 mt-10 relative z-20 pt-16 pb-20 md:pb-120 gap-10">
        
        <!-- Lewa strona  -->
        <div class="__box flex flex-col items-start md:self-end ">
            
            <div class="video-wrapper relative w-[200px] h-[130px] rounded-[16px] overflow-hidden bg-zinc-700 border border-zinc-600 shadow-lg mb-[-100px] ml-25 z-30">
       @if (!empty($g_hero['video']))
            <div class="video-wrapper relative">
                <video
                    id="customVideo"
                    class="w-full">
                    <source src="{{ $g_hero['video'] }}" type="video/mp4">
                    Twoja przeglądarka nie obsługuje odtwarzania wideo.
                </video>
                <button
                    id="customPlayBtn"
                    class="absolute inset-0 flex items-center justify-center bg-black/40 hover:bg-black/60 transition"
                    aria-label="Odtwórz wideo">
                    <img src="http://windes.local/wp-content/uploads/2025/06/play.svg" alt="Play" class="w-20 h-20">
                </button>
            </div>
            @endif
            </div>

            <div class="relative w-75 z-20">
                <img src="/wp-content/uploads/2026/07/box.svg" alt="" class="w-full h-auto">
                <div class="absolute inset-0 z-10 flex flex-col justify-end pl-4 pb-4">
                    @if(!empty($g_hero['video_title']))
                        <h2 class="text-white text-h6 mb-6 max-w-[180px] leading-snug">
                            {{ $g_hero['video_title'] }}
                        </h2>
                    @endif
@if (!empty($g_hero['button2']))
    <a 
        href="{{ $g_hero['button2']['url'] }}"
        class="btn btn-black hero-btn-small"
        data-gsap-element="btn"
    >
        {{ $g_hero['button2']['title'] }}
    </a>
@endif
                </div>
            </div>
        </div>

        <!-- Prawa strona -->
        <div class="__content relative flex flex-col justify-center text-right md:self-start mb-10 md:mb-0 pt-20">
            <h1 data-gsap-element="header" class="pb-10 text-white">
                {!! wp_kses_post($g_hero['title']) !!}
            </h1>
            <div class="inline-buttons m-btn ml-auto">
                @if (!empty($g_hero['button1']))
                <x-button :href="$g_hero['button1']['url']" variant="primary" data-gsap-element="btn">
                    {{ $g_hero['button1']['title'] }}
                </x-button>
                @endif
            </div>
        </div>

    </div>
</section>