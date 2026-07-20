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