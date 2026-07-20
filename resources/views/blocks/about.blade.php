<!--- about -->
<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-about relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main relative">
		<div class="__col grid grid-cols-1 lg:grid-cols-[2fr_1fr] items-center gap-8 lg:gap-12">
			@if (!empty($g_about['image']))
			<div data-gsap-element="img" class="__img  order1  lg:aspect-[383/384]">
				<img class=" " src="{{ $g_about['image']['url'] }}" alt="{{ $g_about['image']['alt'] ?? '' }}">
			</div>
			@endif

			<div class="__about order2">
				<h2 data-gsap-element="header" class="header-line">{{ $g_about['header'] }}</h2>

				<div data-gsap-element="txt" class="__txt text-lg mt-8">
					{!! $g_about['text'] !!}
				</div>

				<div class="inline-buttons m-btn">
					@if (!empty($g_about['button1']))
					<x-button
						:href="$g_about['button1']['url']"
						variant="primary"
						class=""
						data-gsap-element="btn">
						{{ $g_about['button1']['title'] }}
					</x-button>
					@endif

					@if (!empty($g_about['button2']))
					<x-button
						:href="$g_about['button2']['url']"
						variant="secondary"
						class=""
						data-gsap-element="btn">
						{{ $g_about['button2']['title'] }}
					</x-button>
					@endif
				</div>

			</div>

		</div>
	</div>

</section>