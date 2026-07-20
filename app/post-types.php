<?php

/*--- CPT - Produkty ---*/

add_action('init', function () {
	register_post_type('product', [
		'label'         => 'Produkty',
		'labels'        => [
			'name'               => 'Produkty',
			'singular_name'      => 'Produkt',
			'menu_name'          => 'Produkty',
			'all_items'          => 'Wszystkie produkty',
			'add_new'            => 'Dodaj nowy',
			'add_new_item'       => 'Dodaj nowy produkt',
			'edit_item'          => 'Edytuj produkt',
			'new_item'           => 'Nowy produkt',
			'view_item'          => 'Zobacz produkt',
			'view_items'         => 'Zobacz produkty',
			'search_items'       => 'Szukaj produktów',
			'not_found'          => 'Nie znaleziono produktów',
			'not_found_in_trash' => 'Brak produktów w koszu',
			'parent_item_colon'  => 'Produkt nadrzędny:',
		],
		'public'        => true,
		'has_archive'   => true,
		'menu_icon'     => 'dashicons-cart',
		'menu_position' => 20,
		'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
		'show_in_rest'  => true,
		'rewrite'       => ['slug' => 'produkty', 'with_front' => false],
	]);
});

add_action('init', function () {
	register_taxonomy('product_category', ['product'], [
		'label'        => 'Kategorie produktów',
		'labels'       => [
			'name'              => 'Kategorie produktów',
			'singular_name'     => 'Kategoria produktu',
			'search_items'      => 'Szukaj kategorii',
			'all_items'         => 'Wszystkie kategorie',
			'parent_item'       => 'Kategoria nadrzędna',
			'parent_item_colon' => 'Kategoria nadrzędna:',
			'edit_item'         => 'Edytuj kategorię',
			'update_item'       => 'Aktualizuj kategorię',
			'add_new_item'      => 'Dodaj nową kategorię',
			'new_item_name'     => 'Nazwa nowej kategorii',
			'menu_name'         => 'Kategorie',
		],
		'hierarchical' => true,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => ['slug' => 'kategoria-produktu', 'with_front' => false],
	]);
});



/*--- CPT - Portfolio ---*/

add_action('init', function () {
    register_post_type('portfolio', [
        'label'         => 'Nasze realizacje',
        'labels'        => [
            'name'               => 'Nasze realizacje',
            'singular_name'      => 'realizacja',
            'menu_name'          => 'Nasze realizacje',
            'name_admin_bar'     => 'realizacja',
            'add_new'            => 'Dodaj nowy',
            'add_new_item'       => 'Dodaj nową realizację',
            'new_item'           => 'Nowa realizacja',
            'edit_item'          => 'Edytuj realizację',
            'view_item'          => 'Zobacz realizację',
            'all_items'          => 'Wszystkie realizacje',
            'search_items'       => 'Szukaj realizacji',
            'parent_item_colon'  => 'Rodzic:',
            'not_found'          => 'Nie znaleziono realizacji.',
            'not_found_in_trash' => 'Brak realizacji w koszu.'
        ],
        'public'        => true,
        'has_archive'   => true,
        'menu_icon'     => 'dashicons-warning',
        'menu_position' => 20,
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
        'taxonomies'    => ['portfolio_category'],
        'show_in_rest'  => true,
        'rewrite'       => ['slug' => 'portfolio', 'with_front' => false],
    ]); 
});

add_action('init', function () {
    register_taxonomy('portfolio_category', ['portfolio'], [
        'label'        => 'Kategorie realizacji',
        'labels'       => [
            'name'              => 'Kategorie realizacji',
            'singular_name'     => 'Kategoria realizacji',
            'search_items'      => 'Szukaj kategorii',
            'all_items'         => 'Wszystkie kategorie',
            'parent_item'       => 'Kategoria nadrzędna',
            'parent_item_colon' => 'Kategoria nadrzędna:',
            'edit_item'         => 'Edytuj kategorię',
            'update_item'       => 'Aktualizuj kategorię',
            'add_new_item'      => 'Dodaj nową kategorię',
            'new_item_name'     => 'Nazwa nowej kategorii',
            'menu_name'         => 'Kategorie',
        ],
        'hierarchical' => true,
        'public'       => true,
        'show_in_rest' => true,
        'rewrite'      => ['slug' => 'kategoria-realizacji', 'with_front' => false],
    ]);
});


/*--- CPT - Partners ---*/

add_action('init', function () {
    register_post_type('partners', [
        'label'         => 'Nasi partnerzy',
        'labels'        => [
            'name'               => 'Nasi partnerzy',
            'singular_name'      => 'partner',
            'menu_name'          => 'Nasi partnerzy',
            'name_admin_bar'     => 'partner',
            'add_new'            => 'Dodaj nowego',
            'add_new_item'       => 'Dodaj nowego partnera',
            'new_item'           => 'Nowy partner',
            'edit_item'          => 'Edytuj partnera',
            'view_item'          => 'Zobacz partnera',
            'all_items'          => 'Wszyscy partnerzy',
            'search_items'       => 'Szukaj partnerów',
            'parent_item_colon'  => 'Rodzic:',
            'not_found'          => 'Nie znaleziono partnerów.',
            'not_found_in_trash' => 'Brak partnerów w koszu.'
        ],
        'public'        => true,
        'has_archive'   => true,  
        'menu_icon'     => 'dashicons-businessman',
        'menu_position' => 20,
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
        'taxonomies'    => ['partners_category'],
        'show_in_rest'  => true,
        'rewrite'       => ['slug' => 'partners', 'with_front' => false],
    ]); 
});

// /*--- CPT - Works ---*/

// add_action('init', function () {
//     register_post_type('works', [
//         'label'         => 'Nasze realizacje',
//         'labels'        => [ 
//             'name'               => 'Nasze realizacje',
//             'singular_name'      => 'realizacja',
//             'menu_name'          => 'Nasze realizacje',
//             'name_admin_bar'     => 'realizacja',
//             'add_new'            => 'Dodaj nową',
//             'add_new_item'       => 'Dodaj nową realizację',
//             'new_item'           => 'Nowa realizacja',
//             'edit_item'          => 'Edytuj realizację',
//             'view_item'          => 'Zobacz realizację',
//             'all_items'          => 'Wszystkie realizacje',
//             'search_items'       => 'Szukaj realizacji',
//             'parent_item_colon'  => 'Rodzic:',
//             'not_found'          => 'Nie znaleziono realizacji.',
//             'not_found_in_trash' => 'Brak realizacji w koszu.'
//         ],
//         'public'        => true,
//         'has_archive'   => true,  
//         'menu_icon'     => 'dashicons-businessman',
//         'menu_position' => 20,
//         'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
//         'taxonomies'    => ['works_category'],
//         'show_in_rest'  => true,
//         'rewrite'       => ['slug' => 'works', 'with_front' => false],
//     ]); 
// });