<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Support\SectionClasses;


class Reviews extends Block
{
	public $name = 'Slider - Opinie';
	public $description = 'Globalny slider opinii';
	public $slug = 'reviews';
	public $category = 'formatting';
	public $icon = 'format-quote';
	public $keywords = ['reviews', 'opinie'];

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
		$reviews = new FieldsBuilder('reviews');
		$reviews
			->setLocation('block', '==', 'acf/reviews')
			->addText('block-title', [
				'label' => 'Tytuł lokalny',
			])
			->addAccordion('accordion1', [
				'label' => 'Slider - Opinie',
				'open' => false,
				'multi_expand' => true,
			])
			->addTab('Informacja', [
				'placement' => 'top'
			])
			->addMessage(
				'info',
				'Treści opinii edytujesz globalnie w zakładce "Opinie globalne".'
			)
			/*--- USTAWIENIA BLOKU ---*/
			->addTab('Ustawienia bloku', [
				'placement' => 'top'
			])
			->addText('section_id', [
				'label' => 'ID'
			])
			->addText('section_class', [
				'label' => 'Dodatkowe klasy CSS'
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
			->addSelect('background', [
				'label' => 'Kolor tła',
				'choices' => [
					'none' => 'Brak',
					'section-white' => 'Białe',
					'section-light' => 'Jasne',
					'section-gray' => 'Szare',
					'section-brand' => 'Marki',
					'section-gradient' => 'Gradient',
					'section-dark' => 'Ciemne',
				],
				'default_value' => 'none',
			]);
		return $reviews->build();
	}
	public function with(): array
	{
		$fields = [
			// GLOBALNE DANE
			'g_reviews' => get_field('g_reviews', 'option') ?: [],
			'r_reviews' => get_field('r_reviews', 'option') ?: [],
			// LOKALNE USTAWIENIA BLOKU
			'section_id' => get_field('section_id'),
			'section_class' => get_field('section_class'),
			'wide' => (bool) get_field('wide'),
			'nomt' => (bool) get_field('nomt'),
			'background' => get_field('background') ?: 'none',

		];
		$fields['sectionClass'] = SectionClasses::fromMap($fields, [
			'wide' => 'wide',
			'nomt' => '!mt-0',
		]);
		return $fields;
	}
	public function enqueue() {}
}
