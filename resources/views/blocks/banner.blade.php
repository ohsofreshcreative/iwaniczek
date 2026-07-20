@php
$sectionClass = '';
$sectionClass .= $nomt ? ' !mt-0' : '';
@endphp

<!-- banner --->

<section
	data-gsap-anim="section"
	class="b-banner relative {{ $sectionClass }} {{ $section_class }}">

	<div class="__wrapper relative h-120 items-center flex" style="
	background:
		linear-gradient(180deg, rgba(24, 25, 27, 0.95) 4%, rgba(24, 25, 27, 0.00) 32%),
		linear-gradient(180deg, rgba(24, 25, 27, 0.00) 0%, #18191B 100%),
		linear-gradient(0deg, rgba(24, 25, 27, 0.30) 0%, rgba(24, 25, 27, 0.30) 100%),
		url('{{ $g_banner['image']['url'] }}') lightgray 50% / cover no-repeat;
	background-size: cover;
	background-position: center;
">
		<div class="__inside c-main relative">
			<div class="__content ">
				<h1 data-gsap-element="header" class=" text-white m-header">
					{!! $g_banner['header'] !!}
				</h1>
				<a href="#banner-next"
					aria-label="Przewiń do następnej sekcji"
					class="js-banner-next bg-primary h-16 w-16 flex items-center justify-center pointer-events-auto  cursor-pointer transition-all duration-400 animate-bounce ">
					<x-icon.arrow-bottom class="__arrow text-black w-4 h-auto overflow-visible" />
				</a>
			</div>
		</div>
</section>