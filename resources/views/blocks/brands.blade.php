<!--- brands -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-brands relative -smt bg-gray -spt -spb' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>
	<div class="__wrapper c-main relative">
		<div class="__col grid grid-cols-1 lg:grid-cols-[1fr_2fr] items-center gap-8 lg:gap-20">
			@if(!empty($partners))
			<div class="__content order2">
				<h2 data-gsap-element="header" class="header-line">{{ $g_brands['header'] }}</h2>
				<div data-gsap-element="txt" class="__txt mt-4">
					{!! $g_brands['text'] !!}
				</div>
				<div class="inline-buttons m-btn">
					@if (!empty($g_brands['button1']))
					<x-button
						:href="$g_brands['button1']['url']"
						variant=""
						class="btn-outline-primary"
						data-gsap-element="btn">
						{{ $g_brands['button1']['title'] }}
					</x-button>
					@endif
				</div>
			</div>
			<div class="__partners grid grid-cols-2 md:grid-cols-3 gap-6">
				@foreach($partners as $partner)
				@php
				$logo = get_the_post_thumbnail_url($partner->ID, 'medium');
				@endphp
				<a
					href="{{ get_permalink($partner->ID) }}"
					class="bg-white max-h-36 flex items-center justify-center">
					@if($logo)
					<img
						src="{{ $logo }}"
						alt="{{ get_the_title($partner->ID) }}"
						class="h-full w-full object-contain">
					@endif
				</a>
				@endforeach
			</div>
			@endif
		</div>
	</div>
</section>