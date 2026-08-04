<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class MegaMenu extends Field
{
    /**
     * Głębokość aktualnie renderowanej pozycji menu (0 = poziom 1, 1 = poziom 2, ...).
     */
    private static $depth = 0;

    /**
     * Obraz przypisany do pozycji menu, wyświetlany w mega menu po najechaniu.
     * Widoczny w adminie tylko dla pozycji 2. poziomu (bezpośrednich dzieci
     * głównej pozycji menu) — tylko takie są odczytywane przez DropdownWalker.
     */
    public function fields(): array
    {
        add_action('wp_nav_menu_item_custom_fields', function ($item_id, $item, $depth) {
            self::$depth = $depth;
        }, 5, 3);

        add_filter('acf/prepare_field/name=megamenu_image', function ($field) {
            return self::$depth === 1 ? $field : false;
        });

        $megaMenu = new FieldsBuilder('megamenu_item_fields', [
            'title'    => 'Mega menu',
            'style'    => 'default',
            'position' => 'normal',
        ]);

        $megaMenu
            ->setLocation('nav_menu_item', '==', 'all')
            ->addImage('megamenu_image', [
                'label'         => 'Obraz w mega menu',
                'instructions'  => 'Widoczny po prawej stronie, gdy ta pozycja (kategoria) jest aktywna. Pole dotyczy tylko pozycji 2. poziomu.',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'library'       => 'all',
                'mime_types'    => 'jpg,jpeg,png,webp',
            ]);

        return [$megaMenu];
    }
}
