<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Support\SectionClasses;

class ContactBlock extends Block
{
    public $name = 'Kontakt - Blok globalny';
    public $description = 'Wyświetla globalne dane kontaktowe z opcji strony.';
    public $slug = 'contact-block';
    public $category = 'formatting';
    public $keywords = ['kontakt', 'contact'];
    public $mode = 'edit';
    public $supports = [ 
        'align' => false,
        'mode' => true,
        'jsx' => true,
        'anchor' => true,
        'customClassName' => true,
    ];

    public function fields()
    {
        $contactBlock = new FieldsBuilder('contact-block');

        $contactBlock
            ->setLocation('block', '==', 'acf/contact-block')
            ->addText('block-title', [
                'label' => 'Tytuł lokalny (w edytorze)',
                'required' => 0,
            ])
            ->addAccordion('accordion1', [
                'label' => 'Dane kontaktowe i formularz',
                'open' => false,
                'multi_expand' => true,
            ])

            /*--- KARTA 1: INFORMACJE ---*/
            ->addTab('Informacja', ['placement' => 'top'])
            ->addMessage(
                'info',
                'Treści kontaktu edytujesz globalnie w zakładce "Kontakt Globalny" w menu bocznym WP.'
            )

            /*--- KARTA 2: USTAWIENIA WIZUALNE BLOKU ---*/
            ->addTab('Ustawienia bloku', ['placement' => 'top'])
            ->addText('section_id', ['label' => 'ID'])
            ->addText('section_class', ['label' => 'Dodatkowe klasy CSS'])
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
                ],
                'default_value' => 'none',
                'allow_null' => 0,
            ]);

        return $contactBlock->build();
    }

    public function with(): array
    {
        $fields = [
            // Pobieranie danych GLOBALNYCH z Options Page ('option')
            'g_contact_1'   => get_field('g_contact_1', 'option') ?: [],
            'g_contact_2'   => get_field('g_contact_2', 'option') ?: [],
			'title' => get_field('title', 'option'),


            // Ustawienia LOKALNE konkretnego bloku
            'section_id'    => get_field('section_id'),
            'section_class' => get_field('section_class'),
            'flip'          => (bool) get_field('flip'),
            'wide'          => (bool) get_field('wide'),
            'nomt'          => (bool) get_field('nomt'),
            'gap'           => (bool) get_field('gap'),
            'background'    => get_field('background') ?: 'none',
        ];

        $fields['sectionClass'] = SectionClasses::fromMap($fields, [
            'flip' => 'order-flip',
            'wide' => 'wide',
            'nomt' => '!mt-0',
            'gap'  => 'wider-gap',
        ]);

        return $fields;
    }
}