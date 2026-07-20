@php
$sectionClass = '';
$sectionClass .= $nomt ? ' !mt-0' : '';
@endphp

<!-- header --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	class="b-header relative {{ $sectionClass }} {{ $section_class }}">
	<div class="__wrapper relative h-180 items-end flex" style="
	background:
		linear-gradient(180deg, rgba(24, 25, 27, 0.95) 4%, rgba(24, 25, 27, 0.00) 32%),
		linear-gradient(180deg, rgba(24, 25, 27, 0.00) 0%, #18191B 100%),
		linear-gradient(0deg, rgba(24, 25, 27, 0.30) 0%, rgba(24, 25, 27, 0.30) 100%),
		url('{{ $g_header['image']['url'] }}') lightgray 50% / cover no-repeat;
	background-size: cover;
	background-position: center;
">
		<div class="__inside c-main relative pb-28">
			<div class="__content ">
				<h1 data-gsap-element="header" class=" text-white m-title">
					{!! $g_header['header'] !!}
				</h1>
				<div class="text-white text-lg md:w-1/2 mb-8" data-gsap-element="header">
					{!! $g_header['text'] !!}
				</div>

				<a href="#header-next"
					aria-label="Przewiń do następnej sekcji"
					class="js-header-next rotate-90 bg-primary h-16 w-16 flex items-center justify-center pointer-events-auto  cursor-pointer transition-all duration-400 animate-bounce ">
					<x-icon.arrow-right class="__arrow text-black w-4 h-auto overflow-visible" />
				</a>
			</div>
		</div>
</section>