<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ProductDetails extends Field
{
    public function fields(): array
    {
        $product = new FieldsBuilder('product_details');

        $product
            ->setLocation('post_type', '==', 'product')
            ->addText('delivery_time', [
                'label'        => 'Czas realizacji',
                'instructions' => 'Np. "3-5 dni roboczych", "do 2 tygodni"',
            ])
            ->addRepeater('product_info_items', [
                'label'        => 'Dodatkowe informacje',
                'layout'       => 'row',
                'button_label' => 'Dodaj pozycję',
            ])
                ->addText('item_header', [
                    'label' => 'Nagłówek',
                ])
                ->addWysiwyg('item_content', [
                    'label'        => 'Treść',
                    'tabs'         => 'all',
                    'toolbar'      => 'full',
                    'media_upload' => true,
                ])
            ->endRepeater()

            ->addGroup('g_inspire', [
                'label'  => 'Zainspiruj się',
                'layout' => 'block',
            ])
                ->addText('header', [
                    'label'         => 'Nagłówek',
                    'default_value' => 'Zainspiruj się',
                ])
                ->addGallery('gallery', [
                    'label'        => 'Galeria',
                    'preview_size' => 'medium',
                    'library'      => 'all',
                    'min'          => 0,
                    'max'          => 0,
                ])
            ->endGroup();

        return [$product];
    }
}
