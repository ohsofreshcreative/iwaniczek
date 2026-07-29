@props([
'href' => null,
'variant' => 'primary',
'tag' => null
])

@php
$tag = $tag ?? ($href ? 'a' : 'button');
$classes = 'btn btn-' . $variant;
@endphp

@if ($tag === 'a')
<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
	{{ $slot }}
</a>
@else
<button {{ $attributes->merge(['class' => $classes]) }}>
	{{ $slot }}
</button>
@endif
