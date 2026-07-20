<!-- portfolio  -->
@php
$sectionClass = '';

$sectionClass .= $flip ? ' order-flip' : '';
$sectionClass .= $wide ? ' wide' : '';
$sectionClass .= $nomt ? ' !mt-0' : '';
$sectionClass .= $gap ? '   wider-gap' : '';

if (!empty($background) && $background !== 'none') {
$sectionClass .= ' ' . $background;
}
@endphp
<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	class="b-portfolio relative -smt -smb {{ $sectionClass }} {{ $section_class }}">
	<div class="c-main">
	@if(!empty($title))
		<h2 class="m-header header-line">
			{{ $title }}
		</h2>
	@endif
		@if(!empty($posts))
		<div class="swiper portfolio-slider">
			<div class="swiper-wrapper">
				@foreach($posts as $post)
				@php
				$image = get_the_post_thumbnail_url($post->ID, 'large');
				$excerpt = get_the_excerpt($post->ID);
				@endphp
				<div class="swiper-slide">
					<div class="relative h-100 md:h-180 overflow-hidden group">
						@if($image)
						<img
							src="{{ $image }}"
							alt="{{ get_the_title($post->ID) }}"
							class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-102 object-right-bottom">
						@endif
						<div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(24,25,27,0.97)_10.1%,rgba(24,25,27,0.72)_60%,rgba(24,25,27,0.1)_100%)]"></div>
						<div class="absolute inset-0 flex flex-col justify-center px-10 md:px-25">
						<h3 class="text-primary font-bold mb-4">
    {{ html_entity_decode(get_the_title($post->ID)) }}
</h3>
							@if($show_excerpt)
							<div class="text-white text-lg mb-8">
								{!! $excerpt !!}
							</div>
							@endif
							<a
								href="{{ get_permalink($post->ID) }}"
								class="btn btn-primary w-fit">
								Dowiedz się więcej
							</a>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
<div data-gsap-element="arrows" class="flex items-center gap-4 mt-8">
<div class="portfolio-prev bg-primary h-16 w-16 flex items-center justify-center pointer-events-auto cursor-pointer transition-all duration-400 swiper-button-disabled">
	<x-icon.arrow-left class="__arrow text-black w-4 h-auto overflow-visible" />
					</div>
					<div class="portfolio-next bg-primary h-16 w-16 flex items-center justify-center pointer-events-auto  cursor-pointer transition-all duration-400">
	<x-icon.arrow-right class="__arrow text-black w-4 h-auto overflow-visible" />
					</div>
				</div>
		@endif
	</div>
</section>