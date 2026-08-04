<!-- hero --->
<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-hero relative overflow-hidden bg-[#18191B] pb-20 md:pb-90' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	])
	>
	@if(!empty($g_hero['image']['url']))
	<div
		class="absolute inset-0 bg-cover bg-center bg-no-repeat z-10"
		style="background-image: url('{{ $g_hero['image']['url'] }}');">
	</div>
	@endif
	<div class="absolute top-0 inset-0 w-full min-h-[600px] z-20 pointer-events-none">
		<div
			class="absolute inset-0 bg-top-center bg-cover bg-no-repeat"
			style="background-image: url('/wp-content/uploads/2026/07/bg.png');">
		</div>
		<div
			class="absolute inset-0 bg-top-center bg-cover bg-no-repeat opacity-60 rotate"
			style="background-image: url('/wp-content/uploads/2026/07/line.svg'); mask-image: url('/wp-content/uploads/2026/07/bg.png'); mask-size: cover; mask-position: top center; mask-repeat: no-repeat; -webkit-mask-image: url('/wp-content/uploads/2026/07/bg.png'); -webkit-mask-size: cover; -webkit-mask-position: top center; -webkit-mask-repeat: no-repeat;">
		</div>
	</div>
	<div class="__wrapper c-main flex flex-col-reverse md:grid md:grid-cols-2 mt-10 relative gap-10 z-30 pt-40 md:min-h-[650px]">
		<div data-gsap-element="box" class="__box flex flex-col items-start md:self-end">
			<div class="video-wrapper relative w-[200px] h-[130px] rounded-2xl overflow-hidden  border border-zinc-600 shadow-lg mb-[-100px] ml-25 z-40">
				@if (!empty($g_hero['video']))
				<div class="video-wrapper relative h-full w-full">
					<video
						id="heroVideo"
						class="w-full h-full object-cover"
						preload="metadata"
						playsinline>
						<source src="{{ $g_hero['video'] }}" type="video/mp4">
					</video>
					<button
						id="heroPlayBtn"
						class="custom-play-btn absolute inset-0 flex items-center justify-center z-50 cursor-pointer"
						aria-label="Odtwórz wideo">
						<span class="play-circle">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="21" viewBox="0 0 18 21" fill="none">
								<path d="M18 10.3923L-9.08524e-07 20.7846L0 -7.86805e-07L18 10.3923Z" fill="#1A1C1F" />
							</svg>
						</span>
					</button>
				</div>
				@endif
			</div>
			<div class="relative w-75 z-20">
				<img src="/wp-content/uploads/2026/07/box.svg" alt="" class="w-full h-auto">
				<div class="absolute inset-0 z-10 flex flex-col justify-end pl-4 pb-4 mt-2">
					@if(!empty($g_hero['video_title']))
					<h2 class="text-white text-h6 mb-6 max-w-[200px]">
						{{ $g_hero['video_title'] }}
					</h2>
					@endif
					@if (!empty($g_hero['button2']))
					<a
						href="{{ $g_hero['button2']['url'] }}"
						class="btn btn-black hero-btn-small">
						{{ $g_hero['button2']['title'] }}
					</a>
					@endif
				</div>
			</div>
		</div>
		<div class="__content relative flex flex-col justify-center text-left md:text-right w-full md:self-start mb-10 md:mb-0">
		@if(!empty($g_hero['subtitle']))
			<span data-gsap-element="subtitle" class="text-white text-h7 mb-4 md:mb-6 block">
				{{ $g_hero['subtitle'] }}
			</span>
		@endif
			<h1 data-gsap-element="header" class="text-white !font-bold">
				{!! wp_kses_post($g_hero['title']) !!}
			</h1>
			<div class="inline-buttons m-btn mr-auto md:mr-0 md:ml-auto">
				@if (!empty($g_hero['button1']))
				<x-button :href="$g_hero['button1']['url']" variant="primary" data-gsap-element="btn" class="btn-primary-lines">
					{{ $g_hero['button1']['title'] }}
				</x-button>
				@endif
			</div>
		</div>
	</div>
</section>

<!-- popup  -->
<div
	id="heroVideoModal"
	class="fixed inset-0 z-999 bg-black/80 backdrop-blur-sm hidden flex items-center justify-center">
	<div class="relative w-full max-w-7xl mx-auto">
		<button
			id="heroVideoClose"
			class="absolute top-3 right-4 text-white text-4xl cursor-pointer z-10">
			&times;
		</button>
		<video
			id="heroModalVideo"
			class="w-full radius"
			controls
			playsinline>
			<source src="{{ $g_hero['video'] }}" type="video/mp4">
		</video>

	</div>
</div>