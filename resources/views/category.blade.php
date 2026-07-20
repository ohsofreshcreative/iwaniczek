@extends('layouts.app')

@section('content')

@php
$term = get_queried_object();
$categories = get_categories();

$category_header = get_field('category_header', $term);
$category_description = get_field('category_description', $term);
$category_image = get_field('category_image', $term);

$bottom = get_field('bottom', 'option');

// Pobranie pól ACF dla sekcji 'bottom'
$bottom = [
    'g_contact_1'   => get_field('g_contact_1', 'option') ?: [],
    'g_contact_2'   => get_field('g_contact_2', 'option') ?: [],
    'title' => get_field('title', 'option'),
    'flip' => get_field('flip', 'option') ?: false,
];
$g_contact_1 = $bottom['g_contact_1'];
$g_contact_2 = $bottom['g_contact_2'];
$title = $bottom['title'];
$flip = $bottom['flip'];

// Przygotowanie klas CSS
$sectionClass = '';
$sectionClass .= $flip ? ' order-flip' : '';

// Wygenerowanie unikalnego ID dla SVG
$unique_id = 'clip_'.uniqid();
@endphp

<div class="hero category-header relative"  style="background-image: url('/wp-content/uploads/2026/07/blog.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
<div
    class="absolute inset-0"
    style="
        background:
            linear-gradient(180deg, rgba(24, 25, 27, 0.95) 4%, rgba(24, 25, 27, 0) 32%),
            linear-gradient(180deg, rgba(24, 25, 27, 0) 0%, #18191B 100%),
            linear-gradient(0deg, rgba(24, 25, 27, 0.30) 0%, rgba(24, 25, 27, 0.30) 100%);
    "
></div>
	<div class="__wrapper c-main relative z-10 pt-60 pb-26">
		<div class="__content w-full md:w-2/3">
			<h2 class="text-white m-header">
				{!! $category_header ?: get_the_archive_title() !!} 
			</h2>
		
		</div>
          <a href="#banner-next"
					aria-label="Przewiń do następnej sekcji"
					class="js-banner-next bg-primary h-16 w-16 flex items-center justify-center pointer-events-auto  cursor-pointer transition-all duration-400 animate-bounce ">
					<x-icon.arrow-bottom class="__arrow text-black w-4 h-auto overflow-visible" />
				</a>
		</div>
	</div>
</div>
@if (have_posts())
<div class="__posts c-main !mt-10 posts grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
	@while (have_posts()) @php(the_post())
	@includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
	@endwhile
</div>
{{-- {!! get_the_posts_navigation() !!} --}}
{!! the_posts_pagination() !!}
@else
<div class="mt-20 mb-20">
	<div class="c-main">
		<h3 class="">Brak wpisów w tej kategorii.</h3>
		<a class="main-btn m-btn" href="/wszystkie-wpisy/">Sprawdź wszystkie wpisy</a>
	</div>
</div>
@endif
<!-- bottom-block -->
<section data-gsap-anim="section" @if(!empty($section_id)) id="{{ $section_id }}" @endif class="b-contact-block relative -smt text-white{{ $sectionClass }} {{ $section_class }}">
		<div class="__wrapper c-main relative z-20">
			@if(is_page('kontakt') && !empty($title))
    <h2 data-gsap-element="txt" class="header-line m-header md:w-1/2 pt-20">
        {!! $title !!}
    </h2>
@endif
		<div class="relative grid grid-cols-1 lg:grid-cols-2 items-center gap-6 md:gap-10 z-10">
			<div class="__content flex flex-col justify-between gap-6 md:gap-8">
				@if (!empty($g_contact_1['image']))
				<div data-gsap-element="img" class="__img  h-60">
					<img class="w-full h-full object-cover" src="{{ $g_contact_1['image']['url'] }}" alt="{{ $g_contact_1['image']['alt'] ?? '' }}">
				</div>
				@endif
				@if(!empty($g_contact_1['header']))
				<p class="text-2xl !font-bold">{!! $g_contact_1['header'] !!}</p>
				@endif
				<div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray border-t border-secondary-400 p-8">

					@if(!empty($g_contact_1['address']))
					<div data-gsap-element="txt" class=" __address mt-4">
						{!! $g_contact_1['address'] !!}
					</div> @endif
					<div>
						@if(!empty($g_contact_1['phone']))
						<a data-gsap-element="txt" class="__phone flex items-center mb-3" href="tel:{{ str_replace(' ', '', $g_contact_1['phone']) }}">{{ $g_contact_1['phone'] }}</a>
						@endif
						@if(!empty($g_contact_1['phone2']))
						<a data-gsap-element="txt" class="__phone_s flex items-center mb-3" href="tel:{{ str_replace(' ', '', $g_contact_1['phone2']) }}">{{ $g_contact_1['phone2'] }}</a>
						@endif
						@if(!empty($g_contact_1['mail']))
						<a data-gsap-element="txt" class="__mail flex items-center" href="mailto:{{ $g_contact_1['mail'] }}">{{ $g_contact_1['mail'] }}</a>
						@endif
					</div>
				</div>

				@if(!empty($g_contact_1['text']))
				<div data-gsap-element="txt" class="__txt  bg-gray border-t border-secondary-400 p-8">
					{!! $g_contact_1['text'] !!}
				</div> @endif
			</div>


			<div data-gsap-element="form" class="p-8 md:p-10 z-20 relative bg-gray h-full">
				@if(!empty($g_contact_2['title']))
				<h4 class="mb-4">{!! $g_contact_2['title'] !!}</h4>
				@endif
				@if(!empty($g_contact_2['shortcode']))
				{!! do_shortcode($g_contact_2['shortcode']) !!}
				@endif
			</div>
		</div>
	</div>
</section>

@endsection