@php
$contact = get_field('g_contact_info', 'option');
$socials = get_field('social_media', 'option');
$logo_footer = get_field('logo_footer', 'option');
$footer_background = get_field('footer_background', 'option');
@endphp

<footer
	class="footer relative overflow-hidden -smt text-white"
	@if(!empty($footer_background))
	style="
		background:
			linear-gradient(180deg, rgba(15,15,15,0) 0%, #0F0F0F 100%),
			url('{{ $footer_background['url'] }}') center/cover no-repeat,
			#0F0F0F;
	"
	@endif>

	<div class="absolute inset-0 bg-black/80 pointer-events-none"></div>

	<div class="relative z-10 c-main px-6 ">


		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 footer-py">
			<div class="flex flex-col gap-3">
						<div>
				@if(!empty($logo_footer))
				<a href="{{ home_url('/') }}" class="inline-block">
					<img
						src="{{ $logo_footer['url'] }}"
						alt="{{ get_bloginfo('name') }}"
						class="max-w-[240px] h-auto">
				</a>
				@endif
			</div>

@if(!empty($contact['address']))
				<div class="text-base text-white mb-3 _address">
					{!! $contact['address'] !!}
				</div>
				@endif

				@if(!empty($contact['phone']))
				<a
					href="tel:{{ str_replace(' ', '', $contact['phone']) }}"
					class="text-white hover:underline __phone_f">
					{{ $contact['phone'] }}
				</a>
				@endif
				@if(!empty($contact['phone_2']))
				<a
					href="tel:{{ str_replace(' ', '', $contact['phone_2']) }}"
					class="text-white hover:underline __phone_s_f">
					{{ $contact['phone_2'] }}
				</a>
				@endif

				@if(!empty($contact['mail']))
				<a
					href="mailto:{{ $contact['mail'] }}"
					class="text-white hover:underline __mail_f">
					{{ $contact['mail'] }}
				</a>
				@endif

				@if(!empty($socials))
				<div class="flex items-center gap-4 mt-3">
					@foreach($socials as $social)
					<a
						href="{{ $social['link'] }}"
						target="_blank"
						class="hover:opacity-80 transition-opacity">

						<img
							src="{{ get_template_directory_uri() }}/resources/images/{{ $social['icon'] }}.svg"
							alt="{{ $social['icon'] }}"
							class="w-6 h-6">
					</a>
					@endforeach
				</div>
				@endif
			</div>

			@for ($i = 1; $i <= 3; $i++)
				@if (is_active_sidebar('sidebar-footer-' . $i))
				<div class="footer-widget-container flex flex-col gap-3">
				@php(dynamic_sidebar('sidebar-footer-' . $i))
		</div>
		@endif
		@endfor
	</div>
	<div class="footer-bottom border-t border-primary-900 w-full ">
		<div class="flex flex-col md:flex-row justify-between items-center gap-6 py-10">
			<p>
				Copyright ©{{ date('Y') }}
				{{ get_bloginfo('name') }}.
				All Rights Reserved.
			</p>
			<p class="flex items-center gap-2">
				Designed &amp; Developed by
				<a
					target="_blank"
					rel="nofollow"
					href="https://www.ohsofresh.pl"
					title="OhSoFresh">
					<img
						class="oh"
						src="{{ get_template_directory_uri() }}/resources/images/ohsofresh.svg"
						alt="OhSoFresh">

				</a>
			</p>
		</div>
	</div>
	</div>
</footer>