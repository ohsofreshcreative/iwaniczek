<!--- reviews -->
<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-reviews relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>
	<div class="__wrapper c-main !overflow-visible">
		<div class="__content">
			<div data-gsap-element="header" class="__wrapper block w-full md:w-1/2 pb-10">
				<h2 class="text-h5 header-line ">{{ $g_reviews['title']}}</h2>
			</div>
			<div class="swiper reviews-swiper !overflow-visible">
				<div data-gsap-element="swiper" class="swiper-wrapper !items-stretch">
					@foreach($r_reviews as $card)
					<div class="swiper-slide !h-auto flex">
						<div class="__card relative bg-accent-dark px-8 pt-8 pb-12 h-full flex flex-col w-full">
							<div class="relative z-10 flex flex-col gap-4 h-full">
								@if(!empty($card['txt']))
								<div class="review-content-wrapper flex-1 text-white">
									<div class="__txt line-clamp-5 text-lg">
										{!! $card['txt'] !!}
									</div>
									<button class="btn-more hidden underline text-primary-100 font-bold mt-2 cursor-pointer">
										Zobacz całość
									</button>
								</div>
								@endif
								<div class="flex items-center justify-between mt-auto border-t border-secondary-400 pt-4">
									<b class="font-header text-xl !font-bold !text-white">
										{{ $card['name'] }}
									</b>
									<div class="rounded-full bg-primary p-2 flex items-center justify-center w-14 h-14 shrink-0">
										<img src="/wp-content/uploads/2026/07/quote.svg" class="h-6" />
									</div>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
			<div data-gsap-element="arrows" class="flex items-center gap-4 mt-8">
<div class="__prev bg-primary h-16 w-16 flex items-center justify-center pointer-events-auto cursor-pointer transition-all duration-400">
	<x-icon.arrow-left class="__arrow text-black w-4 h-auto overflow-visible" />
					</div>
					<div class="__next bg-primary h-16 w-16 flex items-center justify-center pointer-events-auto  cursor-pointer transition-all duration-400">
	<x-icon.arrow-right class="__arrow text-black w-4 h-auto overflow-visible" />
					</div>
				</div>
		</div>
	</div>
	<div id="review-popup" class="review-popup fixed inset-0 bg-black/50 bg-opacity-70 z-[999] flex items-center justify-center p-4 hidden">
		<div class="review-popup__content text-white bg-accent-dark rounded-lg shadow-xl p-8 md:p-12 max-w-3xl w-full relative">
			<button class="review-popup__close absolute top-4 right-4 text-white hover:text-opacity-40 transition-colors">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
				</svg>
			</button>
			<div id="review-popup-text" class="prose max-w-none mb-4">
			</div>
			<div class="flex items-center gap-4">
				<img src="/wp-content/uploads/2026/07/quote.svg" class="h-6" />
				<b id="review-popup-author" class="font-header text-xl">
				</b>
			</div>
		</div>
	</div>
</section>