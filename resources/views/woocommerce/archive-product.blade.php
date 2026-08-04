{{--
The Template for displaying product archives, including the main shop page which is a post type archive

This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.

HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.

@see https://docs.woocommerce.com/document/template-structure/
@package WooCommerce/Templates
@version 3.4.0
--}}

@extends('layouts.app')

@section('content')
@php
$term = get_queried_object();

/**
* Źródło pól hero: kategoria (WP_Term) albo — na /sklep/ — strona sklepu.
* get_queried_object() na archiwum sklepu zwraca WP_Post strony, ale nie zawsze
* (np. przy filtrach), więc bezpieczniej sięgnąć po wc_get_page_id('shop').
*/
$hero_source = ($term instanceof WP_Term)
? $term
: (function_exists('wc_get_page_id') && wc_get_page_id('shop') > 0 ? wc_get_page_id('shop') : null);

$hero_image = $hero_source ? get_field('hero_image', $hero_source) : null;
if (empty($hero_image['url'])) {
    $hero_image = get_field('hero_image', get_term(28, 'product_cat'));
}
$hero_header_custom = $hero_source ? get_field('hero_header', $hero_source) : null;
$hero_icon = $hero_source ? get_field('icon', $hero_source) : null;
$content_top = $hero_source ? get_field('content_top', $hero_source) : null;
$content_bottom = $hero_source ? get_field('content_bottom', $hero_source) : null;
$display_header = !empty($hero_header_custom) ? $hero_header_custom : woocommerce_page_title(false);
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
do_action('get_header', 'shop');
do_action('woocommerce_before_main_content');

// Pobranie wartości z opcji ACF
$g_values = get_field('g_values', 'option');
$r_values = get_field('r_values', 'option');

// Pobranie opisu kategorii / archiwum
$description = ($term instanceof WP_Term) ? term_description($term->term_id, $term->taxonomy) : '';
@endphp

<header class="b-herosub relative overflow-hidden" {!! empty($hero_image['url']) ? 'style="background: var(--gradient);"' : '' !!}>
	<div class="__wrapper relative">

		@if (!empty($hero_image['url']))
		<figure class="absolute inset-0 z-0 m-0 overflow-hidden">
			<picture>
				<source media="(max-width: 767px)"
					srcset="{{ $hero_image['sizes']['large'] ?? $hero_image['url'] }}" />
				<source media="(min-width: 768px)"
					srcset="{{ $hero_image['sizes']['large'] ?? $hero_image['url'] }}" />
				<img src="{{ $hero_image['url'] }}"
					alt="{{ $hero_image['alt'] ?? '' }}"
					width="{{ $hero_image['width'] ?? '' }}"
					height="{{ $hero_image['height'] ?? '' }}"
					loading="eager" decoding="async" fetchpriority="high"
					class="w-full h-full object-cover object-bottom" />
			</picture>
		</figure>
		<div class="b-herosub__overlay absolute inset-0 z-10"></div>
		@endif

		<div class="__inside c-main relative z-20">
			<div class="__content w-full md:w-2/3 pt-40 pb-16 md:pt-100 md:pb-40">
				@if(function_exists('yoast_breadcrumb'))
				<div class="__breadcrumb mb-4">
					{!! yoast_breadcrumb('<p id="breadcrumbs">','</p>') !!}
				</div>
				@endif

				@if (!empty($hero_icon['url']))
				<figure class="__icon m-0 mb-4 md:mb-6">
					<img src="{{ $hero_icon['url'] }}"
						alt="{{ $hero_icon['alt'] ?? '' }}"
						class="w-12 h-12 md:w-16 md:h-16 object-contain object-left"
						loading="eager" decoding="async" />
				</figure>
				@endif

				<h1 class="text-white [&_strong]:!text-secondary-50"> {!! strip_tags($display_header, '<strong><em><a><br>') !!}</h1>
			</div>
		</div>

	</div>
</header>

@if (!empty($content_top))
<div class="c-main pt-16">
	@include('woocommerce.partials.expandable-content', ['content' => $content_top])
</div>
@endif

<div class="c-main flex flex-col lg:flex-row gap-10 py-16">

	{{-- Sidebar z filtrami --}}
	@if (is_active_sidebar('shop-sidebar'))
	<aside class="__shop-sidebar w-full lg:w-1/4">
		@php dynamic_sidebar('shop-sidebar') @endphp
	</aside>
	@endif

	{{-- Produkty --}}
	<div class="__products min-w-0">
		@if (woocommerce_product_loop())
		@php
		do_action('woocommerce_before_shop_loop');
		woocommerce_product_loop_start();
		@endphp

		@if (wc_get_loop_prop('total'))
		@while (have_posts())
		@php
		the_post();
		do_action('woocommerce_shop_loop');
		wc_get_template_part('content', 'product');
		@endphp
		@endwhile
		@endif

		@php
		woocommerce_product_loop_end();
		do_action('woocommerce_after_shop_loop');
		@endphp
		@else
		@php do_action('woocommerce_no_products_found') @endphp
		@endif
	</div>

</div>

@if (!empty($content_bottom))
<div class="c-main pb-16">
	@include('woocommerce.partials.expandable-content', ['content' => $content_bottom])
</div>
@endif

{{-- Sekcja z opisem kategorii --}}
@if (!empty($description))
<section class="b-category-desc py-12">
	<div class="c-main max-w-4xl mx-auto">
		<div class="relative">
			<div id="category-desc-content" class=" max-w-none text-body overflow-hidden transition-all duration-300 max-h-[140px]">
				{!! $description !!}
			</div>

			{{-- Gradient w kolorze tła (#F9F9FF) znikający po rozwinięciu --}}
			<div id="category-desc-gradient" class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-[#F9F9FF] to-transparent pointer-events-none transition-opacity duration-300"></div>
		</div>

		<div class="text-center mt-6">
			<button id="category-desc-toggle" class="inline-flex items-center gap-2 font-semibold text-primary hover:text-secondary transition-colors group">
				<span class="btn-text">Rozwiń opis</span>
				<svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
				</svg>
			</button>
		</div>
	</div>
</section>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const content = document.getElementById('category-desc-content');
		const button = document.getElementById('category-desc-toggle');
		const gradient = document.getElementById('category-desc-gradient');

		if (!content || !button || !gradient) return;

		// Jeżeli wysokość rzeczywista opisu jest mniejsza niż zwiniecie (140px), ukrywamy dodatki
		if (content.scrollHeight <= 140) {
			button.style.display = 'none';
			gradient.style.display = 'none';
			content.style.maxHeight = 'none';
			return;
		}

		button.addEventListener('click', function() {
			const isOpen = content.classList.contains('is-open');
			const arrow = button.querySelector('svg');
			const textSpan = button.querySelector('.btn-text');

			if (isOpen) {
				content.style.maxHeight = '140px';
				content.classList.remove('is-open');
				gradient.classList.remove('opacity-0');
				arrow.classList.remove('rotate-180');
				textSpan.textContent = 'Rozwiń opis';
			} else {
				content.style.maxHeight = content.scrollHeight + 'px';
				content.classList.add('is-open');
				gradient.classList.add('opacity-0');
				arrow.classList.add('rotate-180');
				textSpan.textContent = 'Zwiń opis';
			}
		});
	});
</script>
@endif

<!-- bottom-block -->
@include('blocks.contact-block', [
'g_contact_1' => get_field('g_contact_1', 'option') ?: [],
'g_contact_2' => get_field('g_contact_2', 'option') ?: [],
'title' => get_field('title', 'option'),
'sectionClass' => 'border-t border-dashed border-white/10 -spt',
'section_id' => '',
'section_class' => '',
'background' => 'none',
])