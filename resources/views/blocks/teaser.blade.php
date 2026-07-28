@php
$sectionClass = '';
$sectionClass .= $nomt ? ' !mt-0' : '';
@endphp

<!-- teaser --->

<section
	data-gsap-anim="section "
	class="b-teaser relative {{ $sectionClass }} {{ $section_class }}">

	<div
		class="__wrapper relative h-120 items-center flex mt-8 bg-cover bg-center"
		 style="background-image: url('{{ $g_teaser['image']['url'] }}');">

<div 
    class="absolute inset-0 " 
    style="background: linear-gradient(90deg, rgba(26, 28, 31, 1) 0%, rgba(26, 28, 31, 0.24) 100%);">
</div>
		<div class="__inside c-main relative">
			<div class="__content w-full md:max-w-2xl md:px-16 px-0"> 
				<h3 data-gsap-element="header" class="!text-h6 !color-primary">
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
							data-gsap-element="btn">
							{{ $g_teaser['button']['title'] }}
						</x-button>
					@endif
				</div>
			</div>
		</div>
	</div>
</section>

