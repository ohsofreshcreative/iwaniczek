<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Support\SectionClasses;

class Partners extends Block
{
    public $name = 'Partners';
    public $description = 'partners';
    public $slug = 'partners';
    public $icon = 'admin-post';
    public $keywords = ['posts', 'partners', 'wpisy', 'kategoria', 'cpt', 'partnerzy'];
    public $mode = 'edit';
    public $supports = [
        'align' => false,
        'mode' => true,
        'jsx' => true,
    ];
 
    public function fields()
    {
        $partners = new FieldsBuilder('partners');

        $partners
            ->setLocation('block', '==', 'acf/partners') // ważne!
            ->addText('block-title', [
                'label' => 'Tytuł bloku',
                'required' => 0,
            ])
            ->addAccordion('accordion1', [
                'label' => 'partners - Ostatnie realizacje',
                'open' => true,
                'multi_expand' => true,
            ])
            /*--- FIELDS ---*/
            ->addTab('Treści', ['placement' => 'top'])
            ->addGroup('posts_settings', ['label' => ''])

            ->addText('title', ['label' => 'Tytuł'])
            ->addTextarea('text', [
                'label' => 'Opis',
                'rows' => 2,
                'new_lines' => 'br',
            ])

            ->addSelect('post_type', [
                'label' => 'Typ wpisów',
                'choices' => [
                    'post' => 'Blog (post)',
                    'partners' => 'partners (CPT)',
                ],
                'default_value' => 'post',
                'allow_null' => 0,
                'ui' => 1,
            ])
            ->addRelationship('selected_posts', [
                'label' => 'Wybierz wpisy ',
                'post_type' => ['post', 'partners'],
                'filters' => ['search', 'taxonomy'],
                'return_format' => 'object', 
            ])

            ->addLink('button', [
                'label' => 'Przycisk',
                'return_format' => 'array',
            ])

            ->addTrueFalse('show_image', [
                'label' => 'Pokaż obrazek',
                'default_value' => 1,
                'ui' => 1,
                'ui_on_text' => 'Tak',
                'ui_off_text' => 'Nie',
            ])

            ->addTrueFalse('show_excerpt', [
                'label' => 'Pokaż fragment treści',
                'default_value' => 1,
                'ui' => 1,
                'ui_on_text' => 'Tak',
                'ui_off_text' => 'Nie',
            ])

            ->endGroup()

            /*--- USTAWIENIA BLOKU ---*/

            ->addTab('Ustawienia bloku', ['placement' => 'top'])
            ->addText('section_id', [
                'label' => 'ID',
            ])
            ->addText('section_class', [
                'label' => 'Dodatkowe klasy CSS',
            ])
            ->addTrueFalse('flip', [
                'label' => 'Odwrotna kolejność',
                'ui' => 1,
                'ui_on_text' => 'Tak',
                'ui_off_text' => 'Nie',
            ])
            ->addTrueFalse('wide', [
                'label' => 'Szeroka kolumna',
                'ui' => 1,
                'ui_on_text' => 'Tak',
                'ui_off_text' => 'Nie',
            ])
            ->addTrueFalse('nomt', [
                'label' => 'Usunięcie marginesu górnego',
                'ui' => 1,
                'ui_on_text' => 'Tak',
                'ui_off_text' => 'Nie',
            ])
            ->addTrueFalse('gap', [
                'label' => 'Większy odstęp',
                'ui' => 1,
                'ui_on_text' => 'Tak',
                'ui_off_text' => 'Nie',
            ])
            ->addSelect('background', [
                'label' => 'Kolor tła',
                'choices' => [
                    'none' => 'Brak (domyślne)',
                    'section-white' => 'Białe',
                    'section-light' => 'Jasne',
                    'section-gray' => 'Szare',
                    'section-brand' => 'Marki',
                    'section-gradient' => 'Gradient',
                    'section-dark' => 'Ciemne',
                    'section-soft-blue' => 'Jasnoniebieskie (#F4F9FF)',
                    'section-lighter-grad' => 'Gradient Pionowy (Lighter)',
                    'section-light-horizontal' => 'Gradient Poziomy',
                ],
                'default_value' => 'none',
                'ui' => 0, // Ulepszony interfejs 
                'allow_null' => 0,
            ]);

        return $partners;
    }

    public function with(): array
    {
        $posts_settings = get_field('posts_settings') ?: [];

$title = $posts_settings['title'] ?? '';
        $posts_settings = get_field('posts_settings') ?: [];
        $post_type = $posts_settings['post_type'] ?? 'post';
        $show_image = array_key_exists('show_image', $posts_settings) ? (bool) $posts_settings['show_image'] : true;
        $show_excerpt = array_key_exists('show_excerpt', $posts_settings) ? (bool) $posts_settings['show_excerpt'] : false;

        $selected_posts = $posts_settings['selected_posts'] ?? [];

        if (!empty($selected_posts)) {
            $posts = $selected_posts;
        } else {
            $args = [
                'post_type' => $post_type,
                'posts_per_page' => 8,
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC',
            ];

            $query = new \WP_Query($args);
            $posts = $query->posts;
        }

        $fields = [
            'title' => $title,
            'posts_settings' => $posts_settings,
            'posts' => $posts, 
            'show_image' => $show_image,
            'show_excerpt' => $show_excerpt,
            'section_id' => get_field('section_id'),
            'section_class' => get_field('section_class'),
            'flip' => (bool) get_field('flip'),
            'wide' => (bool) get_field('wide'),
            'nomt' => (bool) get_field('nomt'),
            'gap' => (bool) get_field('gap'),
            'lightbg' => get_field('lightbg'),
            'graybg' => get_field('graybg'),
            'whitebg' => get_field('whitebg'),
            'brandbg' => get_field('brandbg'),
            'background' => get_field('background') ?: 'none',
        ];

        $fields['sectionClass'] = SectionClasses::fromMap($fields, [
            'flip' => 'order-flip',
            'wide' => 'wide',
            'nomt' => '!mt-0',
            'gap' => 'wider-gap',
        ]);

        return $fields;
    }
}