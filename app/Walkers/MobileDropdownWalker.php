<?php

namespace App\Walkers;

use Walker_Nav_Menu;

class MobileDropdownWalker extends Walker_Nav_Menu
{
    private $current_item_url;
    private bool $in_mega_menu = false;

    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        if ($this->in_mega_menu) {
            return;
        }

        if ($depth === 0 && isset($this->current_item_url)) {
            $output .= "\n<ul x-show=\"open\" x-transition class=\"pl-4 mt-2 space-y-2\" style=\"display: none;\">\n";
            $output .= '<li><a href="' . esc_attr($this->current_item_url) . '" class="block py-1 font-semibold">Zobacz wszystko</a></li>';
            unset($this->current_item_url);
        } else {
            $output .= "\n<ul x-show=\"open\" x-transition class=\"pl-4 mt-2 space-y-2\" style=\"display: none;\">\n";
        }
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        if ($this->in_mega_menu && $depth > 0) {
            return;
        }

        $has_children = in_array('menu-item-has-children', $item->classes);
        $is_mega      = in_array('mega-menu', $item->classes);

        if ($has_children && !$is_mega) {
            $this->current_item_url = $item->url;
        }

        if ($depth === 0 && $is_mega) {
            $this->in_mega_menu = true;
            $output .= '<li x-data="{ open: false }">';
            $output .= '<button @click="open = !open" class="block w-full py-1 text-left relative">';
            $output .= '<span class="!text-white !text-xl hover:!text-primary-400">' . esc_html($item->title) . '</span>';
            $output .= '<svg class="w-5 h-5 text-primary-light transition-transform duration-200 shrink-0 absolute top-1/2 right-0 -translate-y-1/2" :class="{ \'rotate-180\': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>';
            $output .= '</button>';
            $this->build_mobile_mega_menu($output, $item->url);
            return;
        }

        if ($has_children) {
            $output .= '<li x-data="{ open: false }">';
            $output .= '<button @click="open = !open" class="block w-full py-1 text-left relative">';
            $output .= '<span class="!text-white !text-xl hover:!text-primary-400">' . esc_html($item->title) . '</span>';
            $output .= '<svg class="w-5 h-5 text-primary-light transition-transform duration-200 shrink-0 absolute top-1/2 right-0 -translate-y-1/2" :class="{ \'rotate-180\': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>';
            $output .= '</button>';
            return;
        }

        $output .= '<li>';
        $output .= '<a href="' . esc_attr($item->url) . '" class="block py-1">';
        $output .= esc_html($item->title);
        $output .= '</a>';
    }

    public function end_el(&$output, $item, $depth = 0, $args = null)
    {
        if ($this->in_mega_menu && $depth > 0) {
            return;
        }
        $output .= "</li>\n";
    }

    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        if ($this->in_mega_menu) {
            if ($depth === 0) {
                $this->in_mega_menu = false;
            }
            return;
        }
        $output .= "</ul>\n";
    }

    private function build_mobile_mega_menu(string &$output, string $parent_url): void
    {
        $top_cats = get_terms([
            'taxonomy'   => 'product_cat',
            'parent'     => 0,
            'hide_empty' => true,
            'orderby'    => 'menu_order',
            'order'      => 'ASC',
        ]);

        if (empty($top_cats) || is_wp_error($top_cats)) {
            return;
        }

        $output .= '<ul x-show="open" x-transition class="pl-4 mt-2 space-y-1" style="display:none;">';
        $output .= '<li><a href="' . esc_attr($parent_url) . '" class="block py-1 !text-white !text-base font-semibold hover:!text-primary-400">Zobacz wszystko</a></li>';

        foreach ($top_cats as $cat) {
            $subcats = get_terms([
                'taxonomy'   => 'product_cat',
                'parent'     => $cat->term_id,
                'hide_empty' => true,
                'orderby'    => 'menu_order',
                'order'      => 'ASC',
            ]);

            $has_sub  = !empty($subcats) && !is_wp_error($subcats);
            $cat_url  = get_term_link($cat);

            if ($has_sub) {
                $output .= '<li x-data="{ open: false }">';
                $output .= '<button @click="open = !open" class="block w-full py-1 text-left relative">';
                $output .= '<span class="!text-white !text-base hover:!text-primary-400">' . esc_html($cat->name) . '</span>';
                $output .= '<svg class="w-4 h-4 text-primary-light transition-transform duration-200 shrink-0 absolute top-1/2 right-0 -translate-y-1/2" :class="{ \'rotate-180\': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>';
                $output .= '</button>';
                $output .= '<ul x-show="open" x-transition class="pl-4 mt-1 space-y-1" style="display:none;">';
                $output .= '<li><a href="' . esc_attr($cat_url) . '" class="block py-1 !text-secondary-100 !text-sm hover:!text-primary-400">Zobacz wszystko</a></li>';
                foreach ($subcats as $sub) {
                    $output .= '<li><a href="' . esc_attr(get_term_link($sub)) . '" class="block py-1 !text-secondary-100 !text-sm hover:!text-primary-400">' . esc_html($sub->name) . '</a></li>';
                }
                $output .= '</ul>';
                $output .= '</li>';
            } else {
                $output .= '<li>';
                $output .= '<a href="' . esc_attr($cat_url) . '" class="block py-1 !text-white !text-base hover:!text-primary-400">' . esc_html($cat->name) . '</a>';
                $output .= '</li>';
            }
        }

        $output .= '</ul>';
    }
}