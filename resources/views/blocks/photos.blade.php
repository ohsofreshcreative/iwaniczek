<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	class="b-photos relative -smt {{ $sectionClass }} {{ $section_class }} flex flex-col">
	<!-- Treść -->
	<div class="__wrapper c-main relative ">
		<div class="__col grid grid-cols-1 lg:grid-cols-2 items-center gap-10 lg:gap-20 lg:my-20">
			<div class="__photos order2">
				<h2 data-gsap-element="header" class="text-h4">{{ $g_photos['header1'] }}</h2>
				<div data-gsap-element="txt" class="__txt mt-4 pb-6 md:pb-0">
					{!! $g_photos['text1'] !!}
				</div>
			</div>
			@if (!empty($g_photos['image1']))
			<div data-gsap-element="img" class="__img h-full mb-10 lg:mb-0">
				<img src="{{ $g_photos['image1']['url'] }}" alt="{{ $g_photos['image1']['alt'] ?? '' }}">
			</div>
			@endif
		</div>
	</div>
	<!-- Galeria 1 -->
	<div class="__wrapper c-main order-2 lg:order-1">
		@if (!empty($g_photos['photos']))
		<div data-gsap-element="images" class=" grid grid-cols-2 md:grid-cols-3 gap-6 md:gap-10">
			@foreach ($g_photos['photos'] as $image)
			<img class="md:img-m w-full object-cover"
				src="{{ $image['sizes']['large'] ?? $image['url'] }}"
				alt="{{ $image['alt'] ?? '' }}">
			@endforeach
		</div>
		@endif
	</div>
	<!-- Treść -->
	<div class="__wrapper c-main relative order-1 lg:order-2">
		<div class="__col grid grid-cols-1 lg:grid-cols-2 items-center gap-10 lg:gap-20 lg:my-20">

			@if (!empty($g_photos['image']))
			<div data-gsap-element="img" class="__img h-full order1">
				<img src="{{ $g_photos['image']['url'] }}" alt="{{ $g_photos['image']['alt'] ?? '' }}">
			</div>
			@endif

			<div class="__photos order2">
				<h2 data-gsap-element="header" class="text-h4">{{ $g_photos['header'] }}</h2>
				<div data-gsap-element="txt" class="__txt mt-4 pb-6 md:pb-0">
					{!! $g_photos['text'] !!}
				</div>
			</div>
		</div>
	</div>
	<!-- Galeria 2 -->
	<div class="__wrapper c-main order-3">
		@if (!empty($g_photos['photos2']))
		<div data-gsap-element="images" class=" grid grid-cols-2 md:grid-cols-2 gap-6 md:gap-10">
			@foreach ($g_photos['photos2'] as $image)
			<img class="md:img-m w-full object-cover"
				src="{{ $image['sizes']['large'] ?? $image['url'] }}"
				alt="{{ $image['alt'] ?? '' }}">
			@endforeach
		</div>
		@endif
	</div>
</section>