<!--- sale --->

@php
$count  = !empty($products_count) ? (int) $products_count : 8;
$cat_id = !empty($product_category) ? (int) $product_category : null;

$on_sale_ids = wc_get_product_ids_on_sale();

$query_args = [
    'post_type'      => 'product',
    'posts_per_page' => $count,
    'post_status'    => 'publish',
    'post__in'       => !empty($on_sale_ids) ? $on_sale_ids : [0],
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

$products_query = new WP_Query($query_args);
$all_products = [];
if ($products_query->have_posts()) {
    while ($products_query->have_posts()) {
        $products_query->the_post();
        $prod = wc_get_product(get_the_ID());
        if ($prod) {
            // Dla produktów zmiennych budujemy del/ins z najniższej ceny regularnej i promocyjnej
            if ($prod->is_type('variable')) {
                $regular   = $prod->get_variation_regular_price('min');
                $sale      = $prod->get_variation_sale_price('min');
                if ($regular && $sale !== '' && (float) $sale < (float) $regular) {
                    $price_html = '<del>' . wc_price($regular) . '</del><ins>' . wc_price($sale) . '</ins>';
                } else {
                    $price_html = wc_price($sale !== '' ? $sale : $regular);
                }
            } else {
                $price_html = $prod->get_price_html();
            }

            $all_products[] = [
                'id'        => get_the_ID(),
                'title'     => get_the_title(),
                'permalink' => get_permalink(),
                'product'   => $prod,
                'price_html' => $price_html,
                'thumbnail' => get_the_post_thumbnail(get_the_ID(), 'woocommerce_thumbnail', ['class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105']),
            ];
        }
    }
    wp_reset_postdata();
}
@endphp

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-sale relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main">
		<div class="__top">
			<h2 data-gsap-element="header" class="m-header header-line">{{ strip_tags($g_sale['header']) }}</h2>
			@if(!empty($g_sale['text']))
			<p data-gsap-element="text">{{ $g_sale['text'] }}</p>
			@endif
		</div>

		@if(!empty($all_products))
		<div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mt-10">
			@foreach($all_products as $p)

				{{-- Kafelek produktu --}}
				<div data-gsap-element="card">
					<a href="{{ $p['permalink'] }}" class="block group no-underline">
						<div class="overflow-hidden mb-4 bg-white">
							{!! $p['thumbnail'] !!}
						</div>
						<p class="text-h7 font-semibold !text-white group-hover:!text-primary-400 transition-colors duration-200 mb-1">
							{{ $p['title'] }}
						</p>
						<p class="!text-primary-500 font-semibold text-h7">
							{!! $p['price_html'] !!}
						</p>
					</a>
				</div>

			@endforeach
		</div>
		@endif

		@if(!empty($g_sale['button']['url']))
		<div class="mt-10">
			<a href="{{ esc_url($g_sale['button']['url']) }}"
				class="btn btn-primary-lines"
				@if($g_sale['button']['target']) target="{{ $g_sale['button']['target'] }}" @endif>
				{{ $g_sale['button']['title'] }}
			</a>
		</div>
		@endif
	</div>

</section>