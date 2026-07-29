<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});


add_action('pre_get_posts', function ($q) {
  if (is_admin() || !$q->is_main_query()) {
    return;
  }
  if ($q->is_search()) {
    if (!empty($_GET['post_type']) && $_GET['post_type'] === 'produkty') {
      $q->set('post_type', 'produkty');
    }
  }
});


/*--- BREACRUMB SEPARATOR ---*/
add_filter( 'woocommerce_breadcrumb_defaults', function ( $defaults ) {
    // Opakowujemy separator w element <span> z własną klasą CSS.
    $defaults['delimiter'] = '<span class="__separator">•</span>';
    return $defaults;
} );



/**
 * Override WooCommerce Coming Soon template
 */
add_filter('woocommerce_coming_soon_template', function ($template) {
    $custom_template = get_theme_file_path('resources/views/patterns/coming-soon.php');
    
    if (file_exists($custom_template)) {
        return $custom_template;
    }
    
    return $template;
});

/**
 * Dodaje listę „Formaty” do paska ACF WYSIWYG.
 */
add_filter('acf/fields/wysiwyg/toolbars', function ($toolbars) {
    if (!isset($toolbars['Full'])) {
        return $toolbars;
    }

    // Pierwszy rząd przycisków.
    if (!in_array('styleselect', $toolbars['Full'][1], true)) {
        array_unshift($toolbars['Full'][1], 'styleselect');
    }

    return $toolbars;
});

/**
 * Dodaje własne formaty tekstowe do TinyMCE.
 */
add_filter('tiny_mce_before_init', function ($settings) {
    $styleFormats = [
        [
            'title' => 'Kolor wyróżniający',
            'inline' => 'span',
            'classes' => 'text-accent',
            'wrapper' => false,
        ],
    ];

    $settings['style_formats'] = wp_json_encode($styleFormats);

    return $settings;
});

/**
 * Wyświetla kafelki upsell nad formularzem wariantów (priorytet 25, między opisem a add-to-cart).
 */
add_action('woocommerce_single_product_summary', function () {
    global $product;

    if (! $product instanceof \WC_Product) {
        return;
    }

    $upsell_ids = $product->get_upsell_ids();

    if (empty($upsell_ids)) {
        return;
    }

    $upsells = array_filter(
        array_map('wc_get_product', $upsell_ids),
        fn ($p) => $p && $p->is_visible()
    );

    if (empty($upsells)) {
        return;
    }

    // Dodaj bieżący produkt jako pierwszy
    array_unshift($upsells, $product);

    $current_id = $product->get_id();

    echo '<div class="product-upsells-inline border-b border-primary-lighter pb-8 mb-8">';
    echo '<p class="pa_rozmiar block !font-bold pb-2">' . esc_html__('Wybierz kolor:', 'sage') . '</p>';
    echo '<ul class="flex flex-wrap gap-3 list-none !m-0 !p-0">';

    foreach ($upsells as $upsell) {
        $is_current = $upsell->get_id() === $current_id;
        $link       = get_permalink($upsell->get_id());
        $title      = get_the_title($upsell->get_id());
        $thumbnail  = get_the_post_thumbnail($upsell->get_id(), 'woocommerce_thumbnail', ['class' => 'w-full h-full object-cover object-center']);

        $border_class = $is_current
            ? 'ring-4 ring-primary border-transparent'
            : 'border border-gray-100';

        echo '<li class="relative group">';
        if ($is_current) {
            echo '<div class="block w-[104px] h-[104px] bg-white overflow-hidden ' . $border_class . ' cursor-default">';
            echo $thumbnail;
            echo '</div>';
        } else {
            echo '<a href="' . esc_url($link) . '" class="block w-[104px] h-[104px] bg-white overflow-hidden ' . $border_class . ' no-underline">';
            echo $thumbnail;
            echo '</a>';
        }
        echo '<span class="pointer-events-none absolute bottom-full left-1/2 -translate-x-1/2 mb-2 whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-10">' . esc_html($title) . '</span>';
        echo '</li>';
    }

    echo '</ul>';
    echo '</div>';
}, 25);

/**
 * Wyświetl nazwę najgłębszej kategorii produktu nad tytułem (priorytet 4).
 */
add_action('woocommerce_single_product_summary', function () {
    global $product;

    if (! $product instanceof \WC_Product) {
        return;
    }

    $terms = get_the_terms($product->get_id(), 'product_cat');

    if (empty($terms) || is_wp_error($terms)) {
        return;
    }

    // Odfiltruj domyślną kategorię WooCommerce ("Bez kategorii" / "Uncategorized")
    $default_cat_id = (int) get_option('default_product_cat', 0);
    $terms = array_filter($terms, fn ($t) => $t->term_id !== $default_cat_id && $t->slug !== 'uncategorized');

    if (empty($terms)) {
        return;
    }

    // Znajdź najgłębszą kategorię (o największej głębokości w hierarchii)
    $deepest = null;
    $max_depth = -1;

    foreach ($terms as $term) {
        $ancestors = get_ancestors($term->term_id, 'product_cat');
        $depth     = count($ancestors);

        if ($depth > $max_depth) {
            $max_depth = $depth;
            $deepest   = $term;
        }
    }

    if ($deepest) {
        $url = get_term_link($deepest);
        echo '<a href="' . esc_url($url) . '" class="product-category-label">' . esc_html($deepest->name) . '</a>';
    }
}, 4);

/**
 * Przesuń cenę produktu nad przycisk "Dodaj do koszyka" (priorytet 28, zamiast 10).
 * Dla produktów prostych — cena pojawi się nad quantity/buttonem.
 * Dla produktów z wariantami — cena NIE jest renderowana; cena wariantu jest już w single_variation_wrap.
 */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
add_action('woocommerce_single_product_summary', function () {
    global $product;
    if ($product instanceof \WC_Product && $product->is_type('variable')) {
        return;
    }
    echo '<span class="price-label">' . esc_html__('Cena:', 'woocommerce') . '</span>';
    woocommerce_template_single_price();
}, 28);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

/**
 * Usuń domyślną sekcję upsellów WooCommerce ("Może Ci się też spodobać")
 * spod opisu produktu. Kafelki upsell w kolumnie z ceną zostają bez zmian.
 */
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);

/**
 * Ukryj nad listą produktów licznik wyników (.woocommerce-result-count)
 * i select sortowania (.woocommerce-ordering).
 */
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

/**
 * Na kartach produktów (listingi, produkty powiązane, upselle) pokazuj dla
 * produktów z wariantami tylko najniższą cenę zamiast zakresu "OD – DO".
 *
 * Podmieniamy sam callback pętli, a nie filtr `woocommerce_get_price_html` —
 * dzięki temu na stronie pojedynczego produktu zakres zostaje bez zmian.
 */
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
add_action('woocommerce_after_shop_loop_item_title', function () {
    global $product;

    if (! $product instanceof \WC_Product) {
        return;
    }

    if (! $product->is_type('variable')) {
        woocommerce_template_loop_price();

        return;
    }

    // true = ceny z uwzględnieniem ustawień podatkowych dla wyświetlania
    $min_price = $product->get_variation_price('min', true);

    if ('' === $min_price) {
        woocommerce_template_loop_price();

        return;
    }

    $min_regular = $product->get_variation_regular_price('min', true);

    // Najtańszy wariant jest w promocji — pokaż przekreśloną cenę regularną.
    $price_html = ($min_regular && $min_regular > $min_price)
        ? wc_format_sale_price($min_regular, $min_price)
        : wc_price($min_price);

    $price_html .= $product->get_price_suffix();

    echo '<span class="price">' . wp_kses_post($price_html) . '</span>';
}, 10);

/**
 * Przenieś krótki opis produktu do lewej kolumny — pod galerię.
 * Galeria jest na priorytecie 20, więc opis pojawi się po niej (priorytet 30).
 */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
add_action('woocommerce_before_single_product_summary', 'woocommerce_template_single_excerpt', 30);

/**
 * Renderuj dodatkowe informacje (repeater ACF) pod krótkim opisem — lewa kolumna.
 * Każda pozycja to przycisk otwierający drawer z prawej strony (Alpine.js).
 */
add_action('woocommerce_before_single_product_summary', function () {
    global $product;

    if (! $product instanceof \WC_Product) {
        return;
    }

    $items = get_field('product_info_items', $product->get_id());

    if (empty($items)) {
        return;
    }

    $items_data = array_values(array_map(fn ($item) => [
        'title'   => (string) ($item['item_header'] ?? ''),
        'content' => (string) ($item['item_content'] ?? ''),
    ], $items));

    $json = wp_json_encode($items_data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP);
    ?>
    <div class="product-info-items">
        <div class="product-info-items__list">
            <?php foreach ($items_data as $item) : ?>
                <button
                    class="product-info-item-trigger text-h6"
                    type="button"
                    onclick="window.dispatchEvent(new CustomEvent('product-drawer-open', { detail: <?= esc_attr(wp_json_encode($item)) ?> }))">
                    <?= esc_html($item['title']) ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="16" viewBox="0 0 30 16" fill="none">
  <path d="M0 7.59733C0 6.72059 0.710745 6.00984 1.58749 6.00984H27.4624C28.3392 6.00984 29.0499 6.72059 29.0499 7.59733C29.0499 8.47409 28.3392 9.18483 27.4624 9.18483H1.58749C0.710745 9.18483 0 8.47409 0 7.59733Z" fill="white"/>
  <path d="M20.3302 0.464967C20.9502 -0.154989 21.9553 -0.154989 22.5753 0.464967L28.5785 6.4681C29.1984 7.08806 29.1984 8.0932 28.5785 8.71317C27.9585 9.33311 26.9533 9.33311 26.3334 8.71317L20.3302 2.71002C19.7103 2.09007 19.7103 1.08492 20.3302 0.464967Z" fill="white"/>
  <path d="M28.5785 6.49753C27.9584 5.87757 26.9533 5.87757 26.3333 6.49753L20.3302 12.5007C19.7102 13.1206 19.7102 14.1258 20.3302 14.7457C20.9501 15.3657 21.9553 15.3657 22.5752 14.7457L28.5785 8.74258C29.1984 8.12263 29.1984 7.11748 28.5785 6.49753Z" fill="white"/>
</svg>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}, 35);

/**
 * Drawer produktu — w wp_footer, poza strukturą strony.
 * Triggery używają natywnego window.dispatchEvent (bez Alpine).
 */
add_action('wp_footer', function () {
    if (! is_product()) {
        return;
    }
    ?>
    <div x-data="{ open: false, current: { title: '', content: '' } }"
         @product-drawer-open.window="current = $event.detail; open = true"
         @keydown.escape.window="open = false" class="__modal">

        <div x-show="open"
             x-transition:enter="drawer-backdrop-enter"
             x-transition:enter-start="drawer-backdrop-from"
             x-transition:enter-end="drawer-backdrop-to"
             x-transition:leave="drawer-backdrop-enter"
             x-transition:leave-start="drawer-backdrop-to"
             x-transition:leave-end="drawer-backdrop-from"
             style="position:fixed;inset:0;background:rgba(0,0,0,0.55);z-index:9998;display:none;"
             @click="open = false"
             aria-hidden="true"></div>

        <div x-show="open"
             x-transition:enter="drawer-slide-enter"
             x-transition:enter-start="drawer-slide-from"
             x-transition:enter-end="drawer-slide-to"
             x-transition:leave="drawer-slide-enter"
             x-transition:leave-start="drawer-slide-to"
             x-transition:leave-end="drawer-slide-from"
             style="position:fixed;top:0;right:0;height:100%;width:520px;max-width:100%;background:#18191B;z-index:9999;overflow-y:auto;display:none;flex-direction:column;"
             role="dialog"
             aria-modal="true">

            <div style="display:flex;align-items:center;justify-content:space-between;padding:32px 40px 24px;border-bottom:1px solid rgba(255,255,255,0.12);position:sticky;top:0;background:#18191B;z-index:1;">
                <h5 style="color:#fff;font-size:24px;font-weight:600;margin:0;" x-text="current.title"></h5>
                <button @click="open = false"
                        type="button"
                        style="background:transparent;border:1px solid rgba(255,255,255,0.2);color:#fff;width:40px;height:40px;cursor:pointer;display:flex;align-items:center;justify-content:center;"
                        aria-label="Zamknij">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <div style="padding:32px 40px;flex:1;" x-html="current.content" class="__txt"></div>

        </div>

    </div>
    <?php
});


/*--- DYNAMICZNE FRAGMENTY DLA KOSZYKA (SLAJD DRAWER) ---*/

add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {
    // 1. Renderujemy ikonę na pulpit z pliku Blade (jeśli chcemy, lub trzymamy prosty kod w filters)
    ob_start();
    ?>
    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" @click.prevent="window.dispatchEvent(new CustomEvent('cart-open'))" class="relative hover:opacity-80 transition-opacity cart-custom-location-desktop">
        <img src="<?php echo get_template_directory_uri(); ?>/resources/images/cart.svg" alt="Koszyk" />
        <?php if (WC()->cart && WC()->cart->get_cart_contents_count() > 0) : ?>
            <span class="absolute -top-2 -right-2 bg-primary text-secondary text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full cart-count">
                <?php echo WC()->cart->get_cart_contents_count(); ?>
            </span>
        <?php endif; ?>
    </a>
    <?php
    $fragments['a.cart-custom-location-desktop'] = ob_get_clean();

    // 2. Renderujemy ikonę na komórkę
    ob_start();
    ?>
    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" @click.prevent="window.dispatchEvent(new CustomEvent('cart-open'))" class="relative p-2 text-white hover:opacity-80 transition-opacity cart-custom-location-mobile">
        <img src="<?php echo get_template_directory_uri(); ?>/resources/images/cart.svg" class="w-6 h-6" alt="Koszyk" />
        <?php if (WC()->cart && WC()->cart->get_cart_contents_count() > 0) : ?>
            <span class="absolute top-1 right-1 bg-secondary text-primary text-[9px] font-bold w-4.5 h-4.5 flex items-center justify-center rounded-full cart-count">
                <?php echo WC()->cart->get_cart_contents_count(); ?>
            </span>
        <?php endif; ?>
    </a>
    <?php
    $fragments['a.cart-custom-location-mobile'] = ob_get_clean();

    // 3. RENDER ZAWARTOSCI SZUFLADY PROSTO Z BLADE! (BEZ ODPALANIA HTML)
    $fragments['div.cart-drawer-ajax-content'] = '<div class="flex-1 flex flex-col overflow-hidden cart-drawer-ajax-content">' . \Roots\view('partials.cart-drawer-content')->render() . '</div>';

    // 4. Cyferka przy nagłówku Drawera
    $fragments['span.cart-count-badge'] = '<span class="bg-secondary/15 text-secondary text-xs px-2.5 py-0.5 rounded-full cart-count-badge">' . WC()->cart->get_cart_contents_count() . '</span>';

    return $fragments;
});


/*--- WYKRYWANIE DODANIA DO KOSZYKA (DLA EMBEDDED REFRESH / POST) ---*/

add_action('woocommerce_add_to_cart', function () {
    if (!defined('JUST_ADDED_TO_CART')) {
        define('JUST_ADDED_TO_CART', true);
    }
}, 10);


add_action('wp_enqueue_scripts', function () {
    if (function_exists('is_woocommerce')) {
        wp_enqueue_script('wc-cart-fragments');
    }
}, 99);
