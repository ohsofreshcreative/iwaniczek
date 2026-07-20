@php
$sectionClass = '';
$sectionClass .= $nomt ? ' !mt-0' : '';
@endphp

<!-- teaser --->

<section
	data-gsap-anim="section"
	class="b-teaser relative {{ $sectionClass }} {{ $section_class }}">

	<div class="__wrapper relative h-120 items-center flex" style="
	background:
		linear-gradient(180deg, rgba(24, 25, 27, 0.95) 4%, rgba(24, 25, 27, 0.00) 32%),
		linear-gradient(180deg, rgba(24, 25, 27, 0.00) 0%, #18191B 100%),
		linear-gradient(0deg, rgba(24, 25, 27, 0.30) 0%, rgba(24, 25, 27, 0.30) 100%),
		url('{{ $g_teaser['image']['url'] }}') lightgray 50% / cover no-repeat;
	background-size: cover;
	background-position: center;
">
		<div class="__inside c-main relative">
			<div class="__content w-full md:max-w-2xl md:px-16 px-8">
				<h3 data-gsap-element="header" class=" !text-h6 !color-primary">
					{!! $g_teaser['header'] !!}
				</h3>
				<div data-gsap-element="txt" class="__txt mt-2 text-white">
					{!! $g_teaser['text'] !!}
				</div> 
				<div class="m-btn">
				@if (!empty($g_teaser['button']))
						<x-button
						:href="$g_teaser['button']['url']"
						variant="primary"
						class=""
						data-gsap-element="btn">
						{{ $g_teaser['button']['title'] }}
					</x-button>
				@endif
					</div>
			</div>
		</div>
</section>