<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Support\SectionClasses;

class Featured extends Block
{
	public $name = 'Wyróżnione Realizacje';
	public $description = 'featured - wyróżnione realizacje';
	public $slug = 'featured';
	public $category = 'formatting';
	public $icon = 'grid-view';
	public $keywords = ['portfolio', 'realizacje', 'siatka', 'featured', 'projekty'];
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
		$featured = new FieldsBuilder('featured');

		$featured
			->setLocation('block', '==', 'acf/featured')
			->addText('block-title', [
				'label' => 'Tytuł sekcji',
				'required' => 0,
				'default_value' => 'Nasze realizacje',
			])
			->addAccordion('accordion1', [
				'label' => 'Wyróżnione realizacje',
				'open' => true,
				'multi_expand' => true,
			])

			/*--- TREŚĆ ---*/
			->addTab('Treść', ['placement' => 'top'])
			->addRelationship('selected_posts', [
				'label' => 'Wybierz realizacje',
				'instructions' => 'Wybierz realizacje, które mają być wyświetlane w tym bloku.',
				'post_type' => ['portfolio'],
				'filters' => ['search', 'taxonomy'],
				'return_format' => 'object',
				'required' => 1,
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
				'label' => 'Większy odstęp między kafelkami',
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
				'default_value' => 'section-dark',
				'ui' => 0,
				'allow_null' => 0,
			]);

		return $featured;
	}

	public function with(): array
	{
		$fields = [
			'block_title' => get_field('block-title'),
			'posts' => array_slice(get_field('selected_posts') ?: [], 0, 3),
			'section_id' => get_field('section_id'),
			'section_class' => get_field('section_class'),
			'flip' => (bool) get_field('flip'),
			'wide' => (bool) get_field('wide'),
			'nomt' => (bool) get_field('nomt'),
			'gap' => (bool) get_field('gap'),
			'background' => get_field('background') ?: 'none',
		];

		$fields['sectionClass'] = SectionClasses::fromMap($fields, [
			'flip' => 'grid-flip',
			'wide' => 'wide',
			'nomt' => '!mt-0',
			'gap' => 'wider-gap',
		]);

		return $fields;
	}
}
