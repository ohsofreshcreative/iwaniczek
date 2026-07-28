<!--- bestsellers --->

@php
$count  = !empty($products_count) ? (int) $products_count : 10;
$cat_id = !empty($product_category) ? (int) $product_category : null;

$query_args = [
    'post_type'      => 'product',
    'posts_per_page' => $count,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
];

if ($cat_id) {
    $query_args['tax_query'] = [[
        'taxonomy' => 'product_cat',
        'field'    => 'term_id',
        'terms'    => [$cat_id],
    ]];
}

// Pre-fetch products so we can inject the promo tile mid-grid
$products_query = new WP_Query($query_args);
$all_products = [];
if ($products_query->have_posts()) {
    while ($products_query->have_posts()) {
        $products_query->the_post();
        $prod = wc_get_product(get_the_ID());
        if ($prod) {
            $all_products[] = [
                'id'        => get_the_ID(),
                'title'     => get_the_title(),
                'permalink' => get_permalink(),
                'product'   => $prod,
                'thumbnail' => get_the_post_thumbnail(get_the_ID(), 'woocommerce_thumbnail', ['class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105']),
            ];
        }
    }
    wp_reset_postdata();
}
$promo = !empty($r_featured[0]) ? $r_featured[0] : null;
if ($promo) {
    $all_products = array_slice($all_products, 0, 8);
}
@endphp

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-bestsellers relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main">
		<div class="__top">
			<h2 data-gsap-element="header" class="m-header header-line">{{ strip_tags($g_bestsellers['header']) }}</h2>
			@if(!empty($g_bestsellers['text']))
			<p data-gsap-element="text">{{ $g_bestsellers['text'] }}</p>
			@endif
		</div>

		@if(!empty($all_products))
		<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mt-10">
			@foreach($all_products as $i => $p)

				{{-- Po 3. produkcie wstaw kafelek promo (col-span-2) --}}
				@if($promo && $i === 3)
				<div
					data-gsap-element="card"
					class="col-span-2 __card relative overflow-hidden p-10 flex flex-col justify-center text-white min-h-[320px]">

					{{-- Zdjęcie w tle --}}
					@if(!empty($promo['image']))
					<figure class="absolute inset-0 m-0">
						<picture>
							<source srcset="{{ $promo['image']['url'] }}" type="image/{{ pathinfo($promo['image']['url'], PATHINFO_EXTENSION) }}">
							<img
								src="{{ $promo['image']['url'] }}"
								alt="{{ $promo['image']['alt'] ?? '' }}"
								class="w-full h-full object-cover object-center">
						</picture>
					</figure>
					@endif

					{{-- Gradient overlay --}}
					<div class="absolute inset-0 bg-[linear-gradient(90deg,_#18191B_0%,_rgba(24,25,27,0.24)_100%)]"></div>

					{{-- Treść --}}
					<div class="relative z-10">
						@if(!empty($promo['title']))
							<h3 class="text-h5 mb-4 [&_p]:text-h5 [&_p]:mb-0">{!! wp_kses_post($promo['title']) !!}</h3>
						@endif
						@if(!empty($promo['text']))
							<p class="pb-4">{{ $promo['text'] }}</p>
						@endif
						@if(!empty($promo['button']['url']))
							<x-button :href="$promo['button']['url']" variant="primary" data-gsap-element="btn">
								{{ $promo['button']['title'] }}
							</x-button>
						@endif
					</div>
				</div>
				@endif

				{{-- Kafelek produktu --}}
				<div>
					<a href="{{ $p['permalink'] }}" class="block group no-underline">
						<div class="overflow-hidden mb-4 bg-white">
							{!! $p['thumbnail'] !!}
						</div>
						<p class="text-h7 font-semibold !text-white group-hover:!text-primary-400 transition-colors duration-200 mb-1">
							{{ $p['title'] }}
						</p>
						<p class="!text-primary-500 font-semibold text-h7">
							@if($p['product']->is_type('variable'))
								{!! wc_price($p['product']->get_variation_price('min')) !!}
							@else
								{!! $p['product']->get_price_html() !!}
							@endif
						</p>
					</a>
				</div>

			@endforeach
		</div>
		@endif

		@if(!empty($g_bestsellers['button']['url']))
		<div class="mt-10">
			<a href="{{ esc_url($g_bestsellers['button']['url']) }}"
				class="btn btn-primary-lines"
				@if($g_bestsellers['button']['target']) target="{{ $g_bestsellers['button']['target'] }}" @endif>
				{{ $g_bestsellers['button']['title'] }}
			</a>
		</div>
		@endif
	</div>

</section>