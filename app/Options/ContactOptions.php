<?php

namespace App\Options;

use Log1x\AcfComposer\Options;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ContactOptions extends Options
{
	public $name = 'Kontakt globalny';
	public $slug = 'contact-options';
	public $title = 'Kontakt globalny';
	public $capability = 'edit_posts';
	public $redirect = false;
	public $position = 83;

	public function fields(): array
	{
		$contactOptions = new FieldsBuilder('contact_options');

		$contactOptions
			/*--- TAB #1: DANE ---*/
			->setLocation('options_page', '==', 'contact-options')
			->addText('title', ['label' => 'Tytuł sekcji'])

			->addTab('Dane kontaktowe', ['placement' => 'top'])
			->addGroup('g_contact_1', ['label' => 'Dane główne'])
			->addText('header', ['label' => 'Nazwa firmy'])
			->addText('phone', ['label' => 'Numer telefonu'])
			->addText('phone2', ['label' => 'Numer telefonu #2'])
			->addText('mail', ['label' => 'Adres e-mail'])
			->addImage('image', [
				'label' => 'Obraz',
				'return_format' => 'array',
				'preview_size' => 'thumbnail',
			])
				->addWysiwyg('address', [
				'label' => 'Adres',
				'tabs' => 'all', // 'visual', 'text', 'all'
				'toolbar' => 'full', // 'basic', 'full'
				'media_upload' => true, 
			])
			->addWysiwyg('text', [
				'label' => 'Godziny otwarcia',
				'tabs' => 'all', // 'visual', 'text', 'all'
				'toolbar' => 'full', // 'basic', 'full'
				'media_upload' => true,
			])
			->endGroup()

			/*--- TAB #2: FORMULARZ ---*/
			->addTab('Formularz', ['placement' => 'top'])
			->addGroup('g_contact_2', ['label' => 'Ustawienia formularza'])
			->addText('title', ['label' => 'Tytuł nad formularzem'])
			->addText('shortcode', [
				'label' => 'Kod formularza',
				'instructions' => 'Wklej kod formularza z Contact Form 7',
				'default_value' => '[contact-form-7 id="f12c470" title="Formularz kontaktowy"]',
			])
			->endGroup();

		return $contactOptions->build();
	}
}
