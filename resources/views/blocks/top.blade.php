@php
$sectionClass = '';
$sectionClass .= $nomt ? ' !mt-0' : '';
@endphp

<!-- top --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	class="b-top relative {{ $sectionClass }} {{ $section_class }}">

	<div class="__wrapper relative h-120 md:h-180 items-end flex" style="
	background:
		linear-gradient(180deg, rgba(24, 25, 27, 0.95) 4%, rgba(24, 25, 27, 0.00) 32%),
		linear-gradient(180deg, rgba(24, 25, 27, 0.00) 0%, #18191B 100%),
		linear-gradient(0deg, rgba(24, 25, 27, 0.30) 0%, rgba(24, 25, 27, 0.30) 100%),
		url('{{ $g_top['image']['url'] }}') lightgray 50% / cover no-repeat;
	background-size: cover;
	background-position: center;
">
<div class="__inside c-main relative">
    <div class="__content absolute bottom-10 max-w-2xl md:w-1/2 flex flex-col  ">
        @if (!empty($g_top['header']))
            <h1 data-gsap-element="header" class="text-white">
                {{ $g_top['header'] }}
            </h1>
        @endif

        <div data-gsap-element="txt" class="__txt order2 text-white mb-8">
            {!! $g_top['text'] !!}
        </div>

      <a href="#banner-next"
                    aria-label="Przewiń do następnej sekcji"
                    class="js-banner-next bg-primary h-16 w-16 flex items-center justify-center pointer-events-auto  cursor-pointer transition-all duration-400 animate-bounce ">
                    <x-icon.arrow-bottom class="__arrow text-black w-4 h-auto overflow-visible" />
                </a>
    </div>
</div>
</section>