<?php

namespace App\Options;

use Log1x\AcfComposer\Options;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ReviewsOptions extends Options
{
	public $name = 'Opinie globalne';
	public $slug = 'reviews-options';
	public $title = 'Opinie globalne';
	public $capability = 'edit_posts';
	public $redirect = false;
	public $position = 84;


	public function fields(): array
	{
		$reviewsOptions = new FieldsBuilder('reviews_options');

		$reviewsOptions
			->setLocation('options_page', '==', 'reviews-options')
			/*--- TAB TREŚĆ ---*/
			->addTab('Opinie', [
				'placement' => 'top'
			])
			->addGroup('g_reviews', [
				'label' => 'Nagłówek sekcji'
			])
			->addText('title', [
				'label' => 'Tytuł'
			])
			->endGroup()
			/*--- REPEATER OPINII ---*/
			->addRepeater('r_reviews', [
				'label' => 'Opinie',
				'layout' => 'table',
				'min' => 1,
				'max' => 15,
				'button_label' => 'Dodaj opinię'
			])
			->addTextarea('txt', [
				'label' => 'Treść opinii',
				'rows' => 4,
				'new_lines' => 'br',
			])
			->addText('name', [
				'label' => 'Klient'
			])
			->endRepeater();
		return $reviewsOptions->build();
	}
}
