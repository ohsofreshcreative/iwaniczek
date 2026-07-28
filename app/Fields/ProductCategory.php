<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ProductCategory extends Field
{
    /**
     * Pola dla kategorii produktów (sekcja hero na archiwum kategorii).
     */
    public function fields(): array
    {
        $productCategory = new FieldsBuilder('product_category_fields', [
            'title'    => 'Sekcja hero',
            'style'    => 'default',
            'position' => 'normal',
        ]);

        // setLocation() zwraca LocationBuilder — to na nim wywołujemy kolejne ->or().
        $location = $productCategory
            ->setLocation('taxonomy', '==', 'product_cat')
            ->or('taxonomy', '==', 'product_category');

        // Ta sama sekcja hero na stronie sklepu (/sklep/), która jest zwykłą stroną WP.
        if (function_exists('wc_get_page_id') && ($shopId = wc_get_page_id('shop')) > 0) {
            $location->or('page', '==', $shopId);
        }

        $productCategory
            ->addText('hero_header', [
                'label'        => 'Nagłówek hero',
                'instructions' => 'Zostaw puste, aby użyć nazwy kategorii. Dozwolone: <strong>, <em>, <a>, <br>.',
            ])
            ->addImage('hero_image', [
                'label'         => 'Zdjęcie w tle (hero)',
                'instructions'  => 'Tło sekcji hero na archiwum kategorii. Bez zdjęcia użyty zostanie gradient.',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'library'       => 'all',
                'mime_types'    => 'jpg,jpeg,png,webp',
            ])
            ->addImage('icon', [
                'label'         => 'Ikona kategorii',
                'instructions'  => 'Mały symbol nad nagłówkiem. Najlepiej SVG lub PNG z przezroczystym tłem.',
                'return_format' => 'array',
                'preview_size'  => 'thumbnail',
                'library'       => 'all',
                'mime_types'    => 'svg,png,webp',
            ])
            ->addWysiwyg('content_top', [
                'label'        => 'Treść nad listą produktów',
                'instructions' => 'Dłuższy tekst zostanie zwinięty do ok. 200 px z przyciskiem „Rozwiń”.',
                'tabs'         => 'all',
                'toolbar'      => 'full',
                'media_upload' => true,
            ])
            ->addWysiwyg('content_bottom', [
                'label'        => 'Treść pod listą produktów',
                'instructions' => 'Dłuższy tekst zostanie zwinięty do ok. 200 px z przyciskiem „Rozwiń”.',
                'tabs'         => 'all',
                'toolbar'      => 'full',
                'media_upload' => true,
            ]);

        return [$productCategory];
    }
}
