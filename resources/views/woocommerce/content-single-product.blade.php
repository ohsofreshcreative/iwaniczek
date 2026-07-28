@php
/**
* Szablon pojedynczego produktu nadpisany w Blade.
* Klasy Tailwinda dodane są bezpośrednio do sekcji galerii i opisu.
*/
defined('ABSPATH') || exit;

// Pobranie wartości z opcji ACF
$g_values = get_field('g_values', 'option');
$r_values = get_field('r_values', 'option');

// Sekcja "Zainspiruj się" (pole grupowe produktu)
$g_inspire = get_field('g_inspire');

// Akcje wywoływane przed strukturą produktu
if (post_password_required()) {
echo get_the_password_form(); // WPCS: XSS ok.
return;
}
@endphp

<div id="product-{{ the_ID() }}" {{ wc_product_class('', $product) }}>

	<div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

		<div class="relative">
			@php
			/**
			* Hook: woocommerce_before_single_product_summary.
			*
			* @hooked woocommerce_show_product_sale_flash - 10
			* @hooked woocommerce_show_product_images - 20 (Galeria)
			*/
			do_action('woocommerce_before_single_product_summary');
			@endphp
		</div>

		{{-- KOLUMNA PRAWA: Tytuł, Cena, Opis, Przycisk koszyka --}}
		<div class="">

			@php
			/**
			* Hook: woocommerce_single_product_summary.
			*
			* @hooked woocommerce_template_single_title - 5
			* @hooked woocommerce_template_single_rating - 10
			* @hooked woocommerce_template_single_price - 10
			* @hooked woocommerce_template_single_excerpt - 20
			* @hooked woocommerce_template_single_add_to_cart - 30
			* @hooked woocommerce_template_single_meta - 40
			* @hooked woocommerce_template_single_sharing - 50
			* @hooked WC_Structured_Data::generate_product_data() - 60
			*/
			do_action('woocommerce_single_product_summary');
			@endphp
		</div>

	</div>

	@if (!empty($g_inspire['gallery']))
	<section data-gsap-anim="section" class="b-inspire relative bg-secondary -smt">
		<div class="__wrapper">
			@if (!empty($g_inspire['header']))
			<h2 data-gsap-element="header" class="header-line pb-6 mb-14">{{ $g_inspire['header'] }}</h2>
			@endif

			<div data-gsap-element="images" class="lightbox-gallery grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-10">
				@foreach ($g_inspire['gallery'] as $image)
				<a href="{{ $image['url'] }}" data-caption="{{ $image['caption'] ?? '' }}">
					<img class=" w-full !h-full object-cover" src="{{ $image['sizes']['large'] ?? $image['url'] }}" alt="{{ $image['alt'] ?? '' }}" loading="lazy">
				</a>
				@endforeach
			</div>
		</div>
	</section>
	@endif

	<div class="w-full -smt !float-none !clear-both">
		@php
		/**
		* Hook: woocommerce_after_single_product_summary.
		*
		* @hooked woocommerce_output_product_data_tabs - 10
		* @hooked woocommerce_upsell_display - 15
		* @hooked woocommerce_output_related_products - 20
		*/
		do_action('woocommerce_after_single_product_summary');
		@endphp
	</div>

<!-- 
	<section data-gsap-anim="section" class="b-values relative -smt -spb">

		<div class="__wrapper c-main">

			@if (!empty($r_values))
			@php
			$itemCount = count($r_values);
			$gridCols = 1;
			if ($itemCount == 2) $gridCols = 2;
			if ($itemCount == 3) $gridCols = 3;
			if ($itemCount >= 4) $gridCols = 4;
			$gridClass = $gridCols > 1 ? 'grid-cols-1 lg:grid-cols-' . $gridCols : 'grid-cols-1';
			@endphp

			<div class="grid {{ $gridClass }} gap-8 mt-10">
				@foreach ($r_values as $item)
				<div data-gsap-element="card" class="__card relative bg-white p-8 flex flex-col h-full b-shadow">
					@if (!empty($item['image']['url']))
					<img class="mb-6 !max-w-[64px] h-auto object-contain" src="{{ $item['image']['url'] }}" alt="{{ $item['image']['alt'] ?? '' }}" />
					@endif
					@if (!empty($item['title']))
					<p class="text-lg !font-semibold text-primary mb-3">{{ $item['title'] }}</p>
					@endif
					@if (!empty($item['text']))
					<p class="text-sm opacity-80 mt-auto">{{ $item['text'] }}</p>
					@endif
				</div>
				@endforeach
			</div>
			@endif

		</div>

	</section> -->

	<!-- bottom-block -->
	@include('blocks.contact-block', [
		'g_contact_1'   => get_field('g_contact_1', 'option') ?: [],
		'g_contact_2'   => get_field('g_contact_2', 'option') ?: [],
		'title'         => get_field('title', 'option'),
		'sectionClass'  => 'border-t border-dashed border-white/10 -spt',
		'section_id'    => '',
		'section_class' => '',
		'background'    => 'none',
	])

</div>

@php do_action('woocommerce_after_single_product'); @endphp