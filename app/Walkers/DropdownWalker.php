<?php

namespace App\Walkers;

use Walker_Nav_Menu;

class DropdownWalker extends Walker_Nav_Menu
{
    /** Full HTML id of the active level-2 item, e.g. "menu-item-742". */
    private $current_level2_id;

    /** Contact data for the megamenu footer. */
    private $contact;

    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        // depth=0: open the mega menu panel (left col + image placeholder + footer)
        if ($depth === 0) {
            $this->contact = $this->contact ?? (function_exists('get_field') ? get_field('g_contact_info', 'option') : []);

            $output .= '<div x-show="open" x-cloak @click.away="open = false"'
                . ' x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"'
                . ' x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"'
                . ' class="megamenu-content absolute left-1/2 top-full -translate-x-1/2 mt-4 w-[min(92vw,1180px)] bg-secondary text-white shadow-2xl rounded-2xl overflow-hidden z-30" style="display: none;">';

            $output .= '<div class="megamenu-body relative flex flex-wrap gap-x-12 p-10">';
            $output .= '<div class="megamenu-col-left relative w-64 shrink-0">';
            $output .= '<ul class="level-2-list divide-y divide-secondary-400/60">';

            return;
        }

        // depth=1: level-3 list, bound to its parent via matching HTML id / data-parent-id
        if ($depth === 1) {
            $output .= '<ul data-parent-id="' . esc_attr($this->current_level2_id) . '" class="level-3-list absolute top-0 left-full ml-12 w-64 space-y-4">';
            return;
        }

        $output .= '<ul class="pl-4 space-y-2">';
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $has_children = in_array('menu-item-has-children', $item->classes);
        $li_classes = empty($item->classes) ? '' : ' class="' . esc_attr(implode(' ', $item->classes)) . '"';

        // depth=0: top-level nav item
        if ($depth === 0 && $has_children) {
            $output .= '<li x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative ' . esc_attr(implode(' ', $item->classes)) . '">';
            $output .= '<a href="' . esc_attr($item->url) . '" class="inline-flex items-center gap-x-1 text-lg font-medium text-white font-header">';
            $output .= esc_html($item->title);
            $output .= '<svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>';
            $output .= '</a>';
            return;
        }

        // depth=1: left-column mega menu category
        if ($depth === 1) {
            $image    = function_exists('get_field') ? get_field('megamenu_image', $item->ID) : null;
            $imageUrl = !empty($image['sizes']['medium']) ? $image['sizes']['medium'] : ($image['url'] ?? '');

            // Store the FULL HTML id so data-parent-id matches item.id in JS
            if ($has_children) {
                $this->current_level2_id = 'menu-item-' . $item->ID;
            }

            $output .= '<li id="menu-item-' . esc_attr($item->ID) . '" data-image-src="' . esc_attr($imageUrl) . '" class="level-2-item relative -mx-4 px-4 py-4 cursor-pointer transition-colors duration-200 hover:bg-white/5">';
            $output .= '<a href="' . esc_attr($item->url) . '" class="block text-lg text-white">';
            $output .= esc_html($item->title);
            $output .= '</a>';
            return;
        }

        // depth=2: sub-category link
        if ($depth === 2) {
            $output .= '<li' . $li_classes . '>';
            $output .= '<a href="' . esc_attr($item->url) . '" class="flex items-center gap-x-2 text-lg text-white hover:text-primary-300 transition-colors duration-200">';
            $output .= '<svg class="w-3 h-3 text-primary shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" /></svg>';
            $output .= esc_html($item->title);
            $output .= '</a>';
            return;
        }

        // depth=0 without children or other levels: plain link
        $output .= '<li' . $li_classes . '>';
        $output .= '<a href="' . esc_attr($item->url) . '" class="text-lg text-white font-medium font-header">';
        $output .= esc_html($item->title);
        $output .= '</a>';
    }

    public function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $output .= "</li>\n";
    }

    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        if ($depth === 0) {
            $output .= '</ul>'; // .level-2-list
            $output .= '</div>'; // .megamenu-col-left

            $output .= '<div class="megamenu-col-middle-spacer w-64 shrink-0"></div>';
            $output .= '<div class="active-level-2-image relative shrink-0 ml-12 w-[22rem] h-72 rounded-2xl overflow-hidden bg-secondary-800"></div>';

            $output .= '</div>'; // .megamenu-body

            $this->contact = $this->contact ?? (function_exists('get_field') ? get_field('g_contact_info', 'option') : []);
            if (!empty($this->contact) && (!empty($this->contact['phone']) || !empty($this->contact['mail']))) {
                $output .= '<div class="megamenu-footer flex items-center justify-between gap-6 px-10 py-6 border-t border-secondary-400/60">';
                $output .= '<div class="flex items-center gap-6 flex-wrap">';
                $output .= '<span class="text-secondary-100">Masz pytania? Skontaktuj się z nami</span>';

                if (!empty($this->contact['phone'])) {
                    $output .= '<a href="tel:' . esc_attr(str_replace(' ', '', $this->contact['phone'])) . '" class="flex items-center gap-2 text-white hover:text-primary-300 transition-colors duration-200">';
                    $output .= '<svg class="w-4 h-4 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 011 1V20a1 1 0 01-1 1C10.61 21 3 13.39 3 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.46.57 3.58a1 1 0 01-.25 1.01l-2.2 2.2z"/></svg>';
                    $output .= esc_html($this->contact['phone']);
                    $output .= '</a>';
                }

                if (!empty($this->contact['mail'])) {
                    $output .= '<a href="mailto:' . esc_attr($this->contact['mail']) . '" class="flex items-center gap-2 text-white hover:text-primary-300 transition-colors duration-200">';
                    $output .= '<svg class="w-4 h-4 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M2 5.5A2.5 2.5 0 014.5 3h15A2.5 2.5 0 0122 5.5v13a2.5 2.5 0 01-2.5 2.5h-15A2.5 2.5 0 012 18.5v-13zm2.2-.3l7.8 6 7.8-6H4.2zM20 7.4l-7.4 5.7a1 1 0 01-1.2 0L4 7.4V18.5c0 .3.2.5.5.5h15c.3 0 .5-.2.5-.5V7.4z"/></svg>';
                    $output .= esc_html($this->contact['mail']);
                    $output .= '</a>';
                }

                $output .= '</div>';
                $output .= '</div>'; // .megamenu-footer
            }

            $output .= '</div>'; // .megamenu-content
            return;
        }

        $output .= "</ul>\n";
    }
}
