<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Support\SectionClasses;

class Boxes extends Block
{
	public $name = 'Boxy';
	public $description = 'boxes - niestandardowe kafelki';
	public $slug = 'boxes';
	public $category = 'formatting';
	public $icon = 'align-pull-left';
	public $keywords = ['tresc', 'zdjecie'];
	public $mode = 'edit';
	public $supports = [
		'align' => false,
		'mode' => false,
		'jsx' => true,
		'anchor' => true,
		'customClassName' => true,
	];

	public function fields()
	{
		$boxes = new FieldsBuilder('boxes');

		$boxes
			->setLocation('block', '==', 'acf/boxes') // ważne!
			->addText('block-title', [
				'label' => 'Tytuł',
				'required' => 0,
			])
			->addAccordion('accordion1', [
				'label' => 'Kafelki z zaletami firmy',
				'open' => false,
				'multi_expand' => true,
			])
			/*--- tytuł ---*/
			->addTab('Treść', ['placement' => 'top'])
			->addText('title', [
				'label' => 'Tytuł',
			])
			/*--- KAFELEK 1 ---*/
			->addTab('Kafelek 1 - Fachowe doradztwo', ['placement' => 'top'])
			->addGroup('g_box_1', ['label' => ''])
			->addImage('icon', [
				'label' => 'Ikona',
				'return_format' => 'array',
				'preview_size' => 'thumbnail',
			])
			->addText('header', ['label' => 'Nagłówek'])
			->addWysiwyg('text', [
				'label' => 'Treść',
				'tabs' => 'all',
				'toolbar' => 'basic',
			])
			->endGroup()

			/*--- KAFELEK 2 ---*/
			->addTab('Kafelek 2 - Doświadczenie')
			->addGroup('g_box_2')
			->addImage('image', [
				'label' => 'Zdjęcie',
				'return_format' => 'array',
			])
			->addText('number', [
				'label' => 'Liczba',
			])
			->addText('header', [
				'label' => 'Opis',
			])
			->endGroup()

			/*--- KAFELEK 3 ---*/
			->addTab('Kafelek 3 - Produkty')
			->addGroup('g_box_3')
			->addImage('image', [
				'label' => 'Zdjęcie',
				'return_format' => 'array',
			])
			->addText('number', [
				'label' => 'Liczba',
			])
			->addText('header', [
				'label' => 'Opis',
			])
			->endGroup()

			/*--- KAFELEK 4 ---*/
			->addTab('Kafelek 4 - Technologie')
			->addGroup('g_box_4')
			->addImage('image', [
				'label' => 'Zdjęcie',
				'return_format' => 'array',
			])
			->addImage('icon', [
				'label' => 'Ikona',
				'return_format' => 'array',
			])
			->addText('header', ['label' => 'Nagłówek'])
			->addWysiwyg('text', [
				'label' => 'Treść',
				'toolbar' => 'basic',
			])
			->endGroup()

			/*--- KAFELEK 5 ---*/
			->addTab('Kafelek 5 - Logo')
			->addGroup('g_box_5')
			->addImage('background', [
				'label' => 'Tło',
				'return_format' => 'array',
			])
			->addImage('logo', [
				'label' => 'Logo',
				'return_format' => 'array',
			])
			->endGroup()

			/*--- KAFELEK 6 ---*/
			->addTab('Kafelek 6 - Solidność')
			->addGroup('g_box_6')
			->addImage('icon', [
				'label' => 'Ikona',
				'return_format' => 'array',
			])
			->addText('header', ['label' => 'Nagłówek'])
			->addWysiwyg('text', [
				'label' => 'Treść',
				'toolbar' => 'basic',
			])
			->endGroup()

			/*--- KAFELEK 7 ---*/
			->addTab('Kafelek 7 - Szkolenia')
			->addGroup('g_box_7')
			->addImage('icon', [
				'label' => 'Ikona',
				'return_format' => 'array',
			])
			->addText('header', ['label' => 'Nagłówek'])
			->addWysiwyg('text', [
				'label' => 'Treść',
				'toolbar' => 'basic',
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
			->addTrueFalse('nolist', [
				'label' => 'Brak punktatorów',
				'ui' => 1,
				'ui_on_text' => 'Tak',
				'ui_off_text' => 'Nie',
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

		return $boxes;
	}

	public function with(): array
	{
		$fields = [
			'title' => get_field('title'),
			'g_box_1' => get_field('g_box_1'),
			'g_box_2' => get_field('g_box_2'),
			'g_box_3' => get_field('g_box_3'),
			'g_box_4' => get_field('g_box_4'),
			'g_box_5' => get_field('g_box_5'),
			'g_box_6' => get_field('g_box_6'),
			'g_box_7' => get_field('g_box_7'),

			'section_id' => get_field('section_id'),
			'section_class' => get_field('section_class'),

			'flip' => (bool) get_field('flip'),
			'wide' => (bool) get_field('wide'),
			'nomt' => (bool) get_field('nomt'),
			'gap' => (bool) get_field('gap'),
			'nolist' => (bool) get_field('nolist'),

			'background' => get_field('background') ?: 'none',
		];

		$fields['sectionClass'] = SectionClasses::fromMap($fields, [
			'flip' => 'order-flip',
			'wide' => 'wide',
			'nomt' => '!mt-0',
			'gap' => 'wider-gap',
			'nolist' => 'no-list',
		]);

		return $fields;
	}
}
