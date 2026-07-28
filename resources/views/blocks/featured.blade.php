
<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-featured -spt relative' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>


    <div class="c-main ">
        
        @if(!empty($block_title))
            <h2 class="header-line m-header">
                {{ $block_title }}
            </h2>
        @endif

        @if(!empty($posts))
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-16 items-start">
                
                @foreach($posts as $post)
                    @php
                        $image = get_the_post_thumbnail_url($post->ID, 'large');
                        $excerpt = get_the_excerpt($post->ID);
                        $title = html_entity_decode(get_the_title($post->ID));
                        $permalink = get_permalink($post->ID);
                        
                        // Pozycja w sekwencji trzech elementów (0, 1, 2)
                        $position = $loop->index % 3;
                        
                        // Domyślne klasy dla kafelków pionowych (góra/dół)
                        $itemClass = 'flex flex-col w-full gap-4 group ';
                        $imageWrapperClass = 'overflow-hidden block aspect-[4/3] w-full';
                        $contentWrapperClass = 'py-2';
                        
                        if ($position === 0) {
                            // 1. Lewy kafelek: zdjęcie góra, tekst dół
                            $itemClass .= 'md:col-start-1';
                        } elseif ($position === 1) {
                            // 2. Prawy kafelek: tekst góra, zdjęcie dół + przesunięcie w dół
                            $itemClass .= 'md:col-start-2  md:flex-col-reverse';
                        } elseif ($position === 2) {
                            // 3. Trzeci kafelek: zdjęcie po lewej, tekst po prawej (rozciągnięty na 2 kolumny)
                            $itemClass = 'flex flex-col md:flex-row w-full gap-6 lg:gap-12 group md:col-span-2 md:mt-8';
                            $imageWrapperClass = 'overflow-hidden block aspect-[4/3] w-full md:w-1/2 bg-neutral-800 shrink-0';
                            $contentWrapperClass = 'py-2 md:w-1/2 flex flex-col justify-center';
                        }
                    @endphp

                    <div class="{{ $itemClass }}">
                        
                        @if($image)
                            <a href="{{ $permalink }}" class="{{ $imageWrapperClass }}">
                                <img 
                                    src="{{ $image }}" 
                                    alt="{{ $title }}" 
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-103 object-center"
                                    loading="lazy"
                                >
                            </a>
                        @endif

                        <div class="{{ $contentWrapperClass }}">
                            <h3 class="text-h4  mb-2">
                                <a href="{{ $permalink }}">{{ $title }}</a>
                            </h3>
                            @if(!empty($excerpt))
                                <p class="">
                                    {{ strip_tags($excerpt) }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>