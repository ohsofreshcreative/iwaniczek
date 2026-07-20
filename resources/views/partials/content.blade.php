<article @php(post_class('__card'))>

	<a class="rounded-2xl" href="{{ get_permalink() }}">
		<div class="__content relative ">
			@if (has_post_thumbnail())
			<div class="block overflow-hidden">
				<img src="{{ get_the_post_thumbnail_url(null, 'large') }}" alt="{{ get_the_title() }}" class="w-full img-s object-cover">
			</div>
			@endif
			<h6 class="mt-6 text-white">
				{!! get_the_title() !!}
			</h6>
			<!--  <div class="mt-2">
            @php(the_excerpt())
        </div> -->
			<p href="{{ get_permalink() }}" class=" mt-4 !text-primary-500 flex items-center gap-2 text-lg font-bold">
				Dowiedz się więcej
				<svg xmlns="http://www.w3.org/2000/svg" width="8" height="7" viewBox="0 0 8 7" fill="none">
  <path d="M0 3.19049C0 2.8223 0.298477 2.52382 0.666667 2.52382H7.33333C7.70153 2.52382 8 2.8223 8 3.19049C8 3.55868 7.70153 3.85716 7.33333 3.85716H0.666667C0.298477 3.85716 0 3.55868 0 3.19049Z" fill="white"/>
  <path d="M4.33817 0.195263C4.59851 -0.0650875 5.02063 -0.0650875 5.28097 0.195263L7.802 2.71627C8.06233 2.97662 8.06233 3.39873 7.802 3.65908C7.54167 3.91943 7.11953 3.91943 6.8592 3.65908L4.33817 1.13807C4.07781 0.877724 4.07781 0.455611 4.33817 0.195263Z" fill="white"/>
  <path d="M7.802 2.72863C7.5416 2.46828 7.11953 2.46828 6.85913 2.72863L4.33815 5.24964C4.0778 5.50999 4.0778 5.9321 4.33815 6.19245C4.5985 6.45279 5.02061 6.45279 5.28096 6.19245L7.802 3.67144C8.06233 3.41109 8.06233 2.98898 7.802 2.72863Z" fill="white"/>
</svg>
			</p>
		</div>
	</a>
</article>