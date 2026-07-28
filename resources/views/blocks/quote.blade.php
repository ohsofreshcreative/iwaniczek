<!--- quote -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-quote relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main relative bg-gray overflow-hidden">
	<div class="absolute blur bg-primary right-[-305px] bottom-[-936px] w-[1105px] h-[1105px] rounded-full opacity-10 blur-[75px]"></div>
		<div class="__col grid grid-cols-1 lg:grid-cols-[1fr_2fr] items-center gap-8 lg:gap-12">
			@if (!empty($g_quote['image']))
			<div data-gsap-element="img" class="__img lg:h-140 order1">
				<img class=" h-full object-cover" src="{{ $g_quote['image']['url'] }}" alt="{{ $g_quote['image']['alt'] ?? '' }}">
			</div>
			@endif

			<div class="__quote order2">
				<div data-gsap-element="txt" class="__txt text-lg mt-8">
					{!! $g_quote['text'] !!}
				</div>
			</div>
		</div>
	</div>
</section>