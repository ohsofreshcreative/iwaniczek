<!--- promotions --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-promotions relative -smt  -spt -spb' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main">
		<div class="__top">
			@if(!empty($g_promotions['header']))
			<h2 data-gsap-element="header" class="m-header header-line">{{ strip_tags($g_promotions['header']) }}</h2>
			@endif
		</div>

		@if (!empty($r_promotions))
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-10">
			@foreach (array_slice($r_promotions, 0, 2) as $item)
			<div
				data-gsap-element="card"
				class="__card relative overflow-hidden min-h-[240px] p-10 flex flex-col justify-center text-white bg-cover bg-center"
				@if(!empty($item['image']['url']))
				style="background-image:url('{{ $item['image']['url'] }}')"
				@endif>
<div 
    class="absolute inset-0 bg-cover bg-center"
    style="background-image: linear-gradient(90deg, rgba(26, 28, 31, 1) 0%, rgba(26, 28, 31, 0.24) 100%);, url('/image.jpg');">
</div>
				<div class="relative z-10">
					@if (!empty($item['title']))
					<h3 class="text-h5 mb-2"> {!! wp_kses_post($item['title']) !!}</h3>
					@endif

					@if (!empty($item['text']))
					<p class="pb-8">{{ $item['text'] }}</p>
					@endif
					@if (!empty($item['button']))
					<x-button
						:href="$item['button']['url']"
						variant="primary"
						data-gsap-element="btn">
						{{ $item['button']['title'] }}
					</x-button>
					@endif
				</div>
			</div>
			@endforeach
		</div>

		<!-- pozostale trzy  -->
		@if(count($r_promotions) > 2)
		<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
			@foreach (array_slice($r_promotions, 2) as $item)
			<div
				data-gsap-element="card"
				class="__card relative overflow-hidden min-h-[240px] p-10 flex flex-col justify-center text-white bg-cover bg-center"
				@if(!empty($item['image']['url']))
				style="background-image:url('{{ $item['image']['url'] }}')"
				@endif>
<div 
    class="absolute inset-0 bg-cover bg-center"
    style="background-image: linear-gradient(90deg, rgba(26, 28, 31, 1) 0%, rgba(26, 28, 31, 0.24) 100%);, url('/image.jpg');">
</div>

				<div class="relative z-10">
					@if (!empty($item['title']))
					<h3 class="text-h5 mb-2"> {!! wp_kses_post($item['title']) !!}</h3>
					@endif

					@if (!empty($item['text']))
					<p class="pb-8">{{ $item['text'] }}</p>
					@endif
					@if (!empty($item['button']))
					<x-button
						:href="$item['button']['url']"
						variant="primary"
						data-gsap-element="btn">
						{{ $item['button']['title'] }}
					</x-button>
					@endif
				</div>
			</div>
			@endforeach
		</div>
		@endif

		@endif

	</div>

</section>