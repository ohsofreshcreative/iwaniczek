<!-- partners -->
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
	class="b-partners relative -smt -smb {{ $sectionClass }} {{ $section_class }}">

	<div class="c-main">

		@if(!empty($title))
			<h2 class="m-header header-line">
				{{ $title }}
			</h2>
		@endif

		@if(!empty($posts))
			<div class="grid grid-cols-1 md:grid-cols-3 gap-8">

				@foreach($posts as $post)

					@php
						$image = get_the_post_thumbnail_url($post->ID, 'large');
						$excerpt = get_the_excerpt($post->ID);
					@endphp

					<article class="group">

						@if($image)
							<div class="relative aspect-[4/3] overflow-hidden mb-6">
								<img
									src="{{ $image }}"
									alt="{{ get_the_title($post->ID) }}"
									class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
							</div>
						@endif
						@if($show_excerpt)
							<div class="text-white text-lg mb-6">
								{!! $excerpt !!}
							</div>
						@endif

						<a
							href="{{ get_permalink($post->ID) }}"
							class="btn btn-outline-primary w-fit relative">
							Poznaj firmę
						</a>

					</article>

				@endforeach

			</div>
		@endif

	</div>

</section>