<!--- contact-block --->
<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-contact-block relative -smt text-white' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>
 

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