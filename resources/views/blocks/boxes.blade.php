<!--- boxes -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([
		'b-boxes relative -smt',
		$sectionClass => filled($sectionClass),
		$section_class => filled($section_class),
		$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main relative">
		<h2 class="mb-15 header-line">{{ $title }}</h2>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-white">

			{{-- 1 --}}
			<div class="card h-80 md:h-60 bg-gray flex flex-col justify-end p-8">
				<img src="{{ $g_box_1['icon']['url'] }}" alt="" class="w-10 h-auto">
				<h3 class="text-h6 text-white mt-6 mb-2">{{ $g_box_1['header'] }}</h3>
				<div data-gsap-element="txt">
					{!! $g_box_1['text'] !!}
				</div>
			</div>

			{{-- 2 --}}
			<div class="card relative h-80 md:h-60 overflow-hidden">
				<div class="absolute inset-0 bg-black/64 z-10"></div>

				<img
					src="{{ $g_box_2['image']['url'] }}"
					class="absolute inset-0 w-full h-full object-cover"
					alt="">

				<div class="absolute bottom-8 left-8 z-20">
					<span class="text-h2 text-primary-500">{{ $g_box_2['number'] }}</span>
					<h3 class="text-h6 text-white">{{ $g_box_2['header'] }}</h3>
				</div>
			</div>

			{{-- 3 --}}
			<div class="card relative h-80 md:h-130 lg:row-span-2 overflow-hidden">
				<img
					src="{{ $g_box_3['image']['url'] }}"
					class="absolute inset-0 w-full h-full object-cover"
					alt="">

				<div class="absolute bottom-8 left-8 z-10">
					<span class="text-h2 text-primary-500">{{ $g_box_3['number'] }}</span>
					<h3 class="text-h6 text-white">{{ $g_box_3['header'] }}</h3>
				</div>
			</div>

			{{-- 4 --}}
			<div class="card relative h-80 md:h-130 lg:row-span-2 overflow-hidden">
				<img
					src="{{ $g_box_4['image']['url'] }}"
					class="absolute inset-0 w-full h-full object-cover"
					alt="">

				<div class="absolute inset-0 bg-black/72"></div>

				<div class="absolute bottom-8 left-8 right-8 z-10">
					<img src="{{ $g_box_4['icon']['url'] }}" alt="">
					<h3 class="text-h6 text-white mt-6 mb-2">{{ $g_box_4['header'] }}</h3>
					<div data-gsap-element="txt">
						{!! $g_box_4['text'] !!}
					</div>
				</div>
			</div>

			{{-- 5 --}}
<div class="card relative h-80 md:h-60 overflow-hidden">
    <img
        src="/wp-content/uploads/2026/07/shape.svg"
        alt="dekoracja"
        class="absolute top-0 left-0 w-full h-10 object-cover z-30">

    <img
        src="/wp-content/uploads/2026/07/shape.svg"
        alt="dekoracja"
        class="absolute rotate-180 bottom-0 left-0 w-full h-10 object-cover z-30">

    <img
        src="{{ $g_box_5['background']['url'] }}"
        class="absolute inset-0 w-full h-full object-cover"
        alt="">

    <div
        class="absolute inset-0 z-10"
        style="background:
            radial-gradient(
                50% 50% at 50% 50%,
                rgba(0,0,0,0) 0%,
                rgba(0,0,0,0.9) 100%
            ),
            rgba(26,28,31,0.85);">
    </div>

    <div class="relative z-20 flex items-center justify-center h-full w-60 mx-auto">
        <img
            src="{{ $g_box_5['logo']['url'] }}"
            alt="Logo"
            class="w-full h-auto">
    </div>
</div>

			{{-- 6 --}}
			<div class="card h-80 md:h-60 bg-gray flex flex-col justify-end p-8">
				<img src="{{ $g_box_6['icon']['url'] }}" alt="" class="w-10 h-auto">
				<h3 class="text-h6 text-white mt-6 mb-2">{{ $g_box_6['header'] }}</h3>
				<div data-gsap-element="txt">
					{!! $g_box_6['text'] !!}
				</div>
			</div>

			{{-- 7 --}}
			<div class="card h-80 md:h-60 bg-gray flex flex-col justify-end p-8">
				<img src="{{ $g_box_7['icon']['url'] }}" alt="" class="w-10 h-auto">
				<h3 class="text-h6 text-white mt-6 mb-2">{{ $g_box_7['header'] }}</h3>
				<div data-gsap-element="txt">
					{!! $g_box_7['text'] !!}
				</div>
			</div>

		</div>
	</div>

</section>