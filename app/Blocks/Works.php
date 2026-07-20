<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Support\SectionClasses;

class Works extends Block
{
	public $name = 'works';
	public $description = 'works - realizacje (kafelki)';
	public $slug = 'works';
	public $icon = 'admin-post';
	public $keywords = ['works', 'realizacje', 'portfolio', 'cpt'];
	public $mode = 'edit';

	public $supports = [
		'align' => false,
		'mode' => true,
		'jsx' => true,
	];

	public function fields()
	{
		$works = new FieldsBuilder('works');

		$works
			->setLocation('block', '==', 'acf/works')

			->addAccordion('accordion1', [
				'label' => 'Realizacje',
				'open' => true,
			])
			->addTab('Treści', ['placement' => 'top'])
			->addGroup('posts_settings')
			->addTextarea('text', [
				'label' => 'Opis',
				'rows' => 2,
				'new_lines' => 'br',
			])
			->addSelect('post_type', [
				'label' => 'Typ wpisów',
				'choices' => [
					'portfolio' => 'Realizacje',
					'post' => 'Blog',
				],
				'default_value' => 'portfolio',
				'ui' => 1,
			])
			->addRelationship('selected_posts', [
				'label' => 'Wybierz realizacje',
				'post_type' => ['portfolio'],
				'filters' => ['search', 'taxonomy'],
				'return_format' => 'object',
			])
			->addTrueFalse('show_image', [
				'label' => 'Pokaż obrazek',
				'default_value' => 1,
				'ui' => 1,
			])
			->addTrueFalse('show_excerpt', [
				'label' => 'Pokaż opis',
				'default_value' => 0,
				'ui' => 1,
			])
			->endGroup()
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
			])

			->addTrueFalse('wide', [
				'label' => 'Szeroka kolumna',
				'ui' => 1,
			])

			->addTrueFalse('nomt', [
				'label' => 'Bez marginesu górnego',
				'ui' => 1,
			])

			->addTrueFalse('gap', [
				'label' => 'Większy odstęp',
				'ui' => 1,
			])

			->addSelect('background', [
				'label' => 'Kolor tła',
				'choices' => [
					'none' => 'Brak',
					'section-white' => 'Białe',
					'section-light' => 'Jasne',
					'section-gray' => 'Szare',
					'section-dark' => 'Ciemne',
				],
				'default_value' => 'none',
			]);

		return $works;
	}
	public function with(): array
	{
		$posts_settings = get_field('posts_settings') ?: [];
		$post_type = $posts_settings['post_type'] ?? 'portfolio';
		$show_image = array_key_exists('show_image', $posts_settings)
			? (bool) $posts_settings['show_image']
			: true;
		$show_excerpt = array_key_exists('show_excerpt', $posts_settings)
			? (bool) $posts_settings['show_excerpt']
			: false;

		$selected_posts = $posts_settings['selected_posts'] ?? [];

		if (!empty($selected_posts)) {
			$posts = $selected_posts;
		} else {
			$query = new \WP_Query([
				'post_type' => $post_type,
				'posts_per_page' => -1,
				'post_status' => 'publish',
				'orderby' => 'date',
				'order' => 'DESC',

			]);
			$posts = $query->posts;
		}
		foreach ($posts as $item) {
			$terms = get_the_terms(
				$item->ID,
				'portfolio_category'
			);

			$item->portfolio_categories = (
				!empty($terms) &&
				!is_wp_error($terms)
			)
				? $terms
				: [];
		}
		$categories = get_terms([
			'taxonomy' => 'portfolio_category',
			'hide_empty' => true,
		]);

		return [
			'posts' => $posts,
			'categories' => $categories,
			'show_image' => $show_image,
			'show_excerpt' => $show_excerpt,
			'section_id' => get_field('section_id'),
			'section_class' => get_field('section_class'),
			'flip' => (bool)get_field('flip'),
			'wide' => (bool)get_field('wide'),
			'nomt' => (bool)get_field('nomt'),
			'gap' => (bool)get_field('gap'),
			'background' => get_field('background') ?: 'none',
		];
	}
}
