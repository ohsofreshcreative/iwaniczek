<!-- works -->

@php
$sectionClass = '';

$sectionClass .= $flip ? ' order-flip' : '';
$sectionClass .= $wide ? ' wide' : '';
$sectionClass .= $nomt ? ' !mt-0' : '';
$sectionClass .= $gap ? ' wider-gap' : '';

if (!empty($background) && $background !== 'none') {
$sectionClass .= ' ' . $background;
}
@endphp
<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	class="b-works relative -smt -smb {{ $sectionClass }} {{ $section_class }}">
	<div class="c-main">
		@if(!empty($posts))
		@if(!empty($categories) && !is_wp_error($categories))
		<div class="portfolio-filters-slider swiper mb-10">
			<div class="swiper-wrapper ml-4 my-4">
				<div class="swiper-slide">
					<button
						class="portfolio-filter active btn-outline-primary btn whitespace-nowrap"
						data-filter="all">
						Wszystkie realizacje
					</button>
				</div>
				@foreach($categories as $category)
				<div class="swiper-slide">
					<button
						class="portfolio-filter btn-outline-primary btn whitespace-nowrap"
						data-filter="{{ $category->slug }}">
						{{ $category->name }}
					</button>
				</div>
				@endforeach
			</div>
		</div>
		@endif
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
			@foreach($posts as $item)
			@php
			$portfolioCats = !empty($item->portfolio_categories)
			? wp_list_pluck($item->portfolio_categories, 'slug')
			: [];
			@endphp
			<article
				class="portfolio-item group relative border-b border-dashed border-secondary-400"
				data-category="{{ implode(',', $portfolioCats) }}">
				@if($show_image && has_post_thumbnail($item->ID))
				<div class="relative aspect-[4/3] overflow-hidden mb-6">
					<img
						src="{{ get_the_post_thumbnail_url($item->ID, 'large') }}"
						alt="{{ get_the_title($item->ID) }}"
						class="w-full h-full max-h-60 object-cover transition-transform duration-500 group-hover:scale-103" />
				</div>
				@endif
				<h3 class="text-primary-500 text-h6 mb-4">
					{{ html_entity_decode(get_the_title($item->ID)) }}
				</h3>
				<a
					href="{{ get_permalink($item->ID) }}"
					class="absolute inset-0">
				</a>
			</article>
			@endforeach
		</div>
		@endif
	</div>
</section>