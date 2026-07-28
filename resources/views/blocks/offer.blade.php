@php
$sectionClass = '';
$sectionClass .= $flip ? ' order-flip' : '';
$sectionClass .= $nolist ? ' no-list' : '';
$sectionClass .= $wide ? ' wide' : '';
$sectionClass .= $nomt ? ' !mt-0' : '';
$sectionClass .= $gap ? ' wider-gap' : '';

if (!empty($background) && $background !== 'none') {
    $sectionClass .= ' ' . $background;
}

$product_cats = get_terms([
    'taxonomy'   => 'product_cat',
    'parent'     => 0,
    'hide_empty' => true,
    'exclude'    => [get_option('default_product_cat')],
    'orderby'    => 'menu_order',
    'order'      => 'ASC',
]);
@endphp

<!--- offer --->

<section
    data-gsap-anim="section"
    @if(!empty($section_id)) id="{{ $section_id }}" @endif
    class="b-offer relative -smt {{ $sectionClass }} {{ $section_class }}">

    <div class="c-main relative z-20">

        @if(!empty($g_offer['title']))
            <h2 class="header-line">{{ $g_offer['title'] }}</h2>
        @endif

        @if(!empty($product_cats) && !is_wp_error($product_cats))
        <div class="swiper offer-standard relative z-20 mt-14">
            <div class="swiper-wrapper">
                @foreach($product_cats as $index => $cat)
                    @php
                        $thumb_id  = get_term_meta($cat->term_id, 'thumbnail_id', true);
                        $cat_url   = get_term_link($cat);
                        $number    = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                    @endphp
                    <div class="swiper-slide border border-secondary-400  p-8">
                        <a href="{{ is_wp_error($cat_url) ? '#' : esc_url($cat_url) }}" class="info h-80 flex flex-col justify-between no-underline group">

                            @if($thumb_id)
                                <div class="offer-cat-thumb h-20 w-20 w-full overflow-hidden mb-4">
                                    {!! wp_get_attachment_image($thumb_id, 'medium', false, ['class' => 'w-full h-full max-w-20 max-h-20 object-contain']) !!}
                                </div>
                            @endif

                            <div class="mt-auto">
                                <p class="font-header text-h6 !text-white font-semibold mb-1">{{ $number }}</p>

                                <p class="__header text-h6 font-semibold !text-primary-500 group-hover:!text-primary-300 transition-colors duration-200">
                                    {{ $cat->name }}
                                </p>

                                <x-icon.arrow-right class="__arrow text-white w-4 h-auto overflow-visible mt-2" />
                            </div>

                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <div data-gsap-element="arrows" class="flex items-center gap-4 pt-8">
            <div class="offer-prev bg-primary h-16 w-16 flex items-center justify-center cursor-pointer transition-all duration-400">
                <x-icon.arrow-left class="__arrow text-black w-4 h-auto overflow-visible" />
            </div>

            <div class="offer-next bg-primary h-16 w-16 flex items-center justify-center cursor-pointer transition-all duration-400">
                <x-icon.arrow-right class="__arrow text-black w-4 h-auto overflow-visible" />
            </div>
        </div>

    </div>

</section>