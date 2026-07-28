<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-map relative -smt -spt -spb  ' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>
	<!-- map   -->
	<div class="__wrapper c-main">
		<div class="__content ">
		<div class="flex justify-between">
			@if(!empty($g_map['header']))
			<h2 data-gsap-element="header" class="m-header header-line">
				{{ $g_map['header'] }}
			</h2>
			@if(!empty($g_map['button']))
			<div data-gsap-element="button" class="__button">
				<a href="{{ $g_map['button']['url'] }}" target="{{ $g_map['button']['target'] }}" class="btn btn-primary">
					{{ $g_map['button']['title'] }}
				</a>
				</div>
			</div>
			@endif
			@endif
			@if(!empty($g_map['txt']))
			<div data-gsap-element="txt" class="__txt [&_iframe]:w-full w-full [&_iframe]:w-full lg:[&_iframe]:h-[700px] ">
				{!! $g_map['txt'] !!}
			</div>
			@endif
		</div>
	</div>
</section>