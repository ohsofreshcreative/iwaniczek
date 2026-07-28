<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Support\SectionClasses;

class Bestsellers extends Block
{
	public $name = 'Bestsellery';
	public $description = 'bestsellers';
	public $slug = 'bestsellers';
	public $category = 'formatting';
	public $icon = 'ellipsis';
	public $keywords = ['bestsellers', 'kafelki'];
	public $mode = 'edit';
	public $supports = [
		'align' => false,
		'mode' => false,
		'jsx' => true,
	];

	public function fields()
	{
		$bestsellers = new FieldsBuilder('bestsellers');

		$bestsellers
			->setLocation('block', '==', 'acf/bestsellers') // ważne!
			->addText('block-title', [
				'label' => 'Tytuł',
				'required' => 0,
			])
			->addAccordion('accordion1', [
				'label' => 'Bestsellery',
				'open' => false,
				'multi_expand' => true,
			])
			/*--- TAB #1 ---*/
			->addTab('Treści', ['placement' => 'top'])
			->addGroup('g_bestsellers', ['label' => ''])
			->addText('header', ['label' => 'Nagłówek'])
			->addTextarea('text', [
				'label' => 'Opis',
				'rows' => 4,
				'new_lines' => 'br',
			])
			->addLink('button', [
				'label' => 'Przycisk',
				'return_format' => 'array',
			])
			->endGroup()

			/*--- TAB #2 ---*/
			->addTab('Kafelki promo', ['placement' => 'top'])
			->addRepeater('r_featured', [
				'label'        => 'Kafelek wyróżniony',
				'layout'       => 'row',
				'max'          => 1,
				'button_label' => 'Dodaj kafelek',
			])
			->addImage('image', [
				'label'          => 'Zdjęcie w tle',
				'return_format'  => 'array',
				'preview_size'   => 'thumbnail',
			])
			->addWysiwyg('title', [
				'label'   => 'Tytuł',
				'tabs'    => 'all',
				'toolbar' => 'full',
			])
			->addTextarea('text', [
				'label' => 'Opis',
				'rows'  => 3,
			])
			->addLink('button', [
				'label'         => 'Przycisk',
				'return_format' => 'array',
			])
			->endRepeater()

			/*--- TAB #3 ---*/
			->addTab('Produkty', ['placement' => 'top'])
			->addTaxonomy('product_category', [
				'label'         => 'Kategoria produktów',
				'taxonomy'      => 'product_cat',
				'field_type'    => 'select',
				'allow_null'    => 1,
				'return_format' => 'id',
			])
			->addNumber('products_count', [
				'label'         => 'Liczba produktów',
				'default_value' => 10,
				'min'           => 1,
				'max'           => 24,
			])

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
				],
				'default_value' => 'none',
				'ui' => 0, // Ulepszony interfejs
				'allow_null' => 0,
			]);

		return $bestsellers;
	}

	public function with(): array
	{
		$fields = [
			'g_bestsellers'   => get_field('g_bestsellers'),
			'r_featured'      => get_field('r_featured') ?: [],
			'product_category' => get_field('product_category'),
			'products_count'  => get_field('products_count'),

			'section_id'    => get_field('section_id'),
			'section_class' => get_field('section_class'),

			'flip' => (bool) get_field('flip'),
			'wide' => (bool) get_field('wide'),
			'nomt' => (bool) get_field('nomt'),
			'gap'  => (bool) get_field('gap'),

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
