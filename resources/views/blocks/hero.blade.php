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
		<div class="__box flex flex-col items-start md:self-end">
			<div class="video-wrapper relative w-[200px] h-[130px] rounded-2xl overflow-hidden bg-zinc-700 border border-zinc-600 shadow-lg mb-[-100px] ml-25 z-40">
				@if (!empty($g_hero['video']))
				<div class="video-wrapper relative h-full w-full">
					<video
						id="customVideo"
						class="w-full h-full object-cover">
						<source src="{{ $g_hero['video'] }}" type="video/mp4">
						Twoja przeglądarka nie obsługuje odtwarzania wideo.
					</video>
					<button
						id="customPlayBtn"
						class="absolute inset-0 flex items-center justify-center bg-black/40 hover:bg-black/60 transition"
						aria-label="Odtwórz wideo">
						<img src="http://windes.local/wp-content/uploads/2025/06/play.svg" alt="Play" class="w-12 h-12">
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
						class="btn btn-black hero-btn-small"
						data-gsap-element="btn">
						{{ $g_hero['button2']['title'] }}
					</a>
					@endif
				</div>
			</div>
		</div>
		<div class="__content relative flex flex-col justify-center text-left md:text-right w-full md:self-start mb-10 md:mb-0">
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