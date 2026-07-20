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
@endphp

<section
    data-gsap-anim="section"
    @if(!empty($section_id)) id="{{ $section_id }}" @endif
    class="b-offer relative -smt bg-gray -spt -spb {{ $sectionClass }} {{ $section_class }}">

    <div class="c-main relative z-20">

        @if(!empty($g_offer['title']))
            <h2 class="header-line">{{ $g_offer['title'] }}</h2>
        @endif

        <div class="swiper offer-standard relative z-20 mt-6">
            <div class="swiper-wrapper">
                @foreach($offer as $slide)
                    <div class="swiper-slide border border-secondary-400 p-8">
                        <div class="info h-100 flex flex-col justify-between">

                            @if(!empty($slide['icon']))
                                <div class="icon w-20 h-auto">
                                    {!! wp_get_attachment_image($slide['icon']['ID'], 'thumbnail') !!}
                                </div>
                            @endif

                            <div class="mt-auto">
                                @if(!empty($slide['number']))
                                    <p class="__header font-header text-h6 text-white">
                                        {{ $slide['number'] }}
                                    </p>
                                @endif

                                @if(!empty($slide['header']))
                                    <p class="__header text-h6 font-semibold !text-primary-500">
                                        {{ $slide['header'] }}
                                    </p>
                                @endif

                                <x-icon.arrow-right class="__arrow text-white w-4 h-auto overflow-visible mt-2" />
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>

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