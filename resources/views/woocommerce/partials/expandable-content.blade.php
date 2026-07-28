{{--
	Zwijana treść WYSIWYG.

	@param string $content   HTML do wyświetlenia (wymagany)
	@param int    $height    wysokość w stanie zwiniętym w px (domyślnie 200)
	@param string $fade      klasa Tailwinda gradientu, dopasowana do tła (domyślnie from-[#18191B])
	@param string $class     dodatkowe klasy na wrapperze
--}}
@php
	$height = $height ?? 200;
	$fade   = $fade ?? 'from-[#18191B]';
	$class  = $class ?? '';
@endphp

@if (!empty(trim(strip_tags($content, '<img><iframe><table><ul><ol>'))))
<div class="b-expandable {{ $class }}" data-expandable data-collapsed-height="{{ $height }}">

	<div class="__content relative overflow-hidden transition-[max-height] duration-300 ease-out"
		data-expandable-content
		style="max-height: {{ $height }}px">

		<div class="__entry max-w-none text-body">
			{!! $content !!}
		</div>

		<div class="pointer-events-none absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t {{ $fade }} to-transparent transition-opacity duration-300"
			data-expandable-fade></div>
	</div>

	<div class="text-center mt-6">
		<button type="button"
			class="inline-flex items-center gap-2 font-semibold text-primary hover:text-primary-hover transition-colors group"
			data-expandable-toggle
			data-label-more="Rozwiń"
			data-label-less="Zwiń"
			aria-expanded="false">
			<span data-expandable-label>Rozwiń</span>
			<svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
			</svg>
		</button>
	</div>

</div>
@endif
