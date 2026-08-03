<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Bubble extends Field
{
	public function fields(): array
	{
		$bubble = new FieldsBuilder('bubble');

		$bubble
			->setLocation('options_page', '==', 'bubble')
			->addTrueFalse('active', [
				'label'       => 'Włącz dymek',
				'ui'          => 1,
				'ui_on_text'  => 'Tak',
				'ui_off_text' => 'Nie',
				'default_value' => 1,
			])
			->addImage('image', [
				'label'         => 'Zdjęcie',
				'return_format' => 'array',
				'preview_size'  => 'medium',
				'library'       => 'all',
			])
			->addText('heading', [
				'label' => 'Nagłówek',
			])
			->addTextarea('text', [
				'label' => 'Tekst',
				'rows'  => 4,
			])
			->addLink('button', [
				'label'         => 'Przycisk',
				'return_format' => 'array',
			])
			->addText('collapsed_text', [
				'label'        => 'Tekst po zwinięciu (na buttonie)',
				'instructions' => 'Ten tekst pojawi się na pływającym przycisku po zamknięciu dymka.',
			]);

		return [$bubble];
	}
}
