@php
$categories = get_the_category();
$category = !empty($categories) ? $categories[0] : null;

$bottom = get_field('bottom', 'option');

// Pobranie pól ACF dla sekcji 'bottom'
$bottom = [
    'g_contact_1'   => get_field('g_contact_1', 'option') ?: [],
    'g_contact_2'   => get_field('g_contact_2', 'option') ?: [],
    'title' => get_field('title', 'option'),
    'flip' => get_field('flip', 'option') ?: false,
];
$g_contact_1 = $bottom['g_contact_1'];
$g_contact_2 = $bottom['g_contact_2'];
$title = $bottom['title'];
$flip = $bottom['flip'];

// Przygotowanie klas CSS
$sectionClass = '';
$sectionClass .= $flip ? ' order-flip' : '';
@endphp

<section data-gsap-anim="section" class="hero-blog relative overflow-visible" style="background-image: url('/wp-content/uploads/2026/07/blog-single.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="absolute inset-0" style="background: linear-gradient(180deg, rgba(24, 25, 27, 0.95) 4%, rgba(24, 25, 27, 0) 32%), linear-gradient(180deg, rgba(24, 25, 27, 0) 0%, #18191B 100%), linear-gradient(0deg, rgba(24, 25, 27, 0.30) 0%, rgba(24, 25, 27, 0.30) 100%);"></div>
    <div class="__wrapper c-main relative z-10 md:pt-60 md:pb-26 py-20">
        <div class="__content w-full sm:w-3/4  pb-30">
            <div class="__top mt-20">
                <h1 data-gsap-element="header" class="text-h2 text-white my-6">{{ get_the_title() }}</h1>
          <a href="#banner-next"
					aria-label="Przewiń do następnej sekcji"
					class="js-banner-next bg-primary h-16 w-16 flex items-center justify-center pointer-events-auto  cursor-pointer transition-all duration-400 animate-bounce ">
					<x-icon.arrow-bottom class="__arrow text-black w-4 h-auto overflow-visible" />
				</a>
            </div>
        </div>
    </div>
</section>

@php
$content = apply_filters('the_content', get_the_content());
preg_match_all('/<h([1-4])[^>]*>(.*?)<\/h[1-4]>/', $content, $matches, PREG_SET_ORDER);

$toc = '<nav class="toc"><ul>';
$used_ids = [];
$counter = 1; // Licznik do numeracji 1, 2, 3...

foreach ($matches as $match) {
    $level = $match[1];
    $title_text = strip_tags($match[2]);
    $id = sanitize_title($title_text);
    $base_id = $id;
    $i = 2;
    while (in_array($id, $used_ids)) {
        $id = $base_id . '-' . $i;
        $i++;
    }
    $used_ids[] = $id;
    $content = preg_replace(
        '/<h' . $level . '[^>]*>' . preg_quote($match[2], '/') . '<\/h' . $level . '>/',
        '<h' . $level . ' id="' . $id . '">' . $match[2] . '</h' . $level . '>',
        $content,
        1
    );
    // Dodano dynamiczną numerację $counter. przed tytułem w spisie treści
    $toc .= '<li class="toc-h' . $level . '"><a href="#' . $id . '"><span class="toc-number">' . $counter . '.</span> ' . $title_text . '</a></li>';
    $counter++;
}
$toc .= '</ul></nav>';
@endphp

<div class="__content c-main __entry -smt grid grid-cols-1 md:grid-cols-[1fr_2.5fr] gap-12 relative z-10 -mt-20">
    <div class="relative md:sticky top-0 md:top-10 self-start pt-4 order-3 md:order-none">
        <p class="text-h5 m-title !text-primary mb-6 font-bold">
            Co znajdziesz w artykule:
        </p>

        @if(count($matches))
            {!! $toc !!}
        @endif
    </div>
    <div class="__entry-content flex flex-col gap-10 md:-mt-30 order-1 md:order-none">
        @if(has_post_thumbnail())
            <div data-gsap-element="image" class="w-full img-2xl overflow-hidden -mt-20">
                {!! get_the_post_thumbnail(get_the_ID(), 'large', [
                    'class' => 'w-full object-cover max-h-[500px]'
                ]) !!}
            </div>
        @endif
        <div class="md:hidden">
            <p class="text-h5 m-title !text-primary mb-6 font-bold">
                Co znajdziesz w artykule:
            </p>
            @if(count($matches))
                {!! $toc !!}
            @endif
        </div>
        <div class="prose max-w-none text-white">
            {!! $content !!}
        </div>
    </div>
</div>

@php
$current_id = get_the_ID();
$categories = wp_get_post_categories($current_id);
$related_args = [
    'category__in' => $categories,
    'post__not_in' => [$current_id],
    'posts_per_page' => 3,
    'ignore_sticky_posts' => 1,
];
$related_query = new WP_Query($related_args);
@endphp

@if($related_query->have_posts())
<section class="related-posts  bg-gray -smt -spt -spb ">
<div class="__wrapper c-main relative z-20">
    <h3 class="text-h2 m-header header-line">Podobne wpisy</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @while($related_query->have_posts())
            @php($related_query->the_post())
            <article @php(post_class('p-6 flex flex-col'))>
                <header>
                    @if(has_post_thumbnail())
                    <a href="{{ get_permalink() }}">
                        {!! get_the_post_thumbnail(null, 'large', ['class' => 'featured-image object-cover img-m']) !!}
                    </a>
                    @endif
                    <h2 class="entry-title text-h6 mt-4">
                        <a href="{{ get_permalink() }}">
                            {{ get_the_title() }}
                        </a>
                    </h2>
                </header>
                <a class="mt-auto pt-4 !text-primary-500 flex items-center gap-2 text-lg font-bold" href="{{ get_permalink() }}">
                    Przeczytaj <svg xmlns="http://www.w3.org/2000/svg" width="8" height="7" viewBox="0 0 8 7" fill="none"><path d="M0 3.19049C0 2.8223 0.298477 2.52382 0.666667 2.52382H7.33333C7.70153 2.52382 8 2.8223 8 3.19049C8 3.55868 7.70153 3.85716 7.33333 3.85716H0.666667C0.298477 3.85716 0 3.55868 0 3.19049Z" fill="white"/><path d="M4.33817 0.195263C4.59851 -0.0650875 5.02063 -0.0650875 5.28097 0.195263L7.802 2.71627C8.06233 2.97662 8.06233 3.39873 7.802 3.65908C7.54167 3.91943 7.11953 3.91943 6.8592 3.65908L4.33817 1.13807C4.07781 0.877724 4.07781 0.455611 4.33817 0.195263Z" fill="white"/><path d="M7.802 2.72863C7.5416 2.46828 7.11953 2.46828 6.85913 2.72863L4.33815 5.24964C4.0778 5.50999 4.0778 5.9321 4.33815 6.19245C4.5985 6.45279 5.02061 6.45279 5.28096 6.19245L7.802 3.67144C8.06233 3.41109 8.06233 2.98898 7.802 2.72863Z" fill="white"/></svg>
                </a>
            </article>
        @endwhile
        @php(wp_reset_postdata())
    </div>
</div>
</section>
@endif

<!-- kontakt -->
<section data-gsap-anim="section" @if(!empty($section_id)) id="{{ $section_id }}" @endif class="b-contact-block relative -smt text-white{{ $sectionClass }} {{ $section_class }}">
    <div class="__wrapper c-main relative z-20">
        @if(is_page('kontakt') && !empty($title))
        <h2 data-gsap-element="txt" class="header-line m-header md:w-1/2 pt-20">
            {!! $title !!}
        </h2>
        @endif
        <div class="relative grid grid-cols-1 lg:grid-cols-2 items-center gap-6 md:gap-10 z-10">
            <div class="__content flex flex-col justify-between gap-6 md:gap-8">
                @if (!empty($g_contact_1['image']))
                <div data-gsap-element="img" class="__img h-60">
                    <img class="w-full h-full object-cover" src="{{ $g_contact_1['image']['url'] }}" alt="{{ $g_contact_1['image']['alt'] ?? '' }}">
                </div>
                @endif
                @if(!empty($g_contact_1['header']))
                <p class="text-2xl !font-bold">{!! $g_contact_1['header'] !!}</p>
                @endif
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray border-t border-secondary-400 p-8">
                    @if(!empty($g_contact_1['address']))
                    <div data-gsap-element="txt" class="__address mt-4">
                        {!! $g_contact_1['address'] !!}
                    </div> 
                    @endif
                    <div>
                        @if(!empty($g_contact_1['phone']))
                        <a data-gsap-element="txt" class="__phone flex items-center mb-3" href="tel:{{ str_replace(' ', '', $g_contact_1['phone']) }}">{{ $g_contact_1['phone'] }}</a>
                        @endif
                        @if(!empty($g_contact_1['phone2']))
                        <a data-gsap-element="txt" class="__phone_s flex items-center mb-3" href="tel:{{ str_replace(' ', '', $g_contact_1['phone2']) }}">{{ $g_contact_1['phone2'] }}</a>
                        @endif
                        @if(!empty($g_contact_1['mail']))
                        <a data-gsap-element="txt" class="__mail flex items-center" href="mailto:{{ $g_contact_1['mail'] }}">{{ $g_contact_1['mail'] }}</a>
                        @endif
                    </div>
                </div>
                @if(!empty($g_contact_1['text']))
                <div data-gsap-element="txt" class="__txt bg-gray border-t border-secondary-400 p-8">
                    {!! $g_contact_1['text'] !!}
                </div> 
                @endif
            </div>

            <div data-gsap-element="form" class="p-8 md:p-10 z-20 relative bg-gray h-full">
                @if(!empty($g_contact_2['title']))
                <h4 class="mb-4">{!! $g_contact_2['title'] !!}</h4>
                @endif
                @if(!empty($g_contact_2['shortcode']))
                {!! do_shortcode($g_contact_2['shortcode']) !!}
                @endif
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const headings = document.querySelectorAll('h1[id], h2[id], h3[id], h4[id]');
        const tocLinks = document.querySelectorAll('.toc ul li a');

        function updateActiveLink() {
            headings.forEach((heading) => {
                const headingTop = heading.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;

                if (headingTop < windowHeight - 300) {
                    tocLinks.forEach((link) => {
                        link.parentNode.classList.remove('active');
                    });

                    const id = heading.id;
                    const activeLink = document.querySelector(`.toc ul li a[href="#${id}"]`);
                    if (activeLink) {
                        activeLink.parentNode.classList.add('active');
                    }
                }
            });
        }
        updateActiveLink();
        window.addEventListener('scroll', updateActiveLink);
    });
</script>