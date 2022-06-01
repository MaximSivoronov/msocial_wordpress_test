<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'crb_attach_theme_options');
function crb_attach_theme_options()
{
    Container::make('post_meta', 'Новость')
        ->where('post_type', '=', 'news')
        ->add_fields([
            Field::make('text', 'crb_news_title', 'Заголовок'),
            Field::make('text', 'crb_news_text', 'Текст новости'),
            Field::make('image', 'crb_news_image', 'Картинка'),
            Field::make('date', 'crb_news_date', 'Дата новости'),
        ]);

    Container::make('post_meta', 'Продукт')
        ->where('post_type', '=', 'product')
        ->add_fields([
            Field::make('text', 'crb_product_title', 'Название'),
            Field::make('text', 'crb_product_description', 'Описание'),
            Field::make('media_gallery', 'crb_product_gallery', 'Галерея'),
            Field::make('text', 'crb_product_equipment', 'Комплектация'),
            Field::make('select', 'crb_product_maker', 'Производитель')
                ->add_options([
                'apple' => 'Apple',
                'google' => 'Google',
                'xiaomi' => 'Xiaomi',
                ]),
            Field::make('text', 'crb_product_price', 'Стоимость'),
        ]);
}

add_action('init', 'setupMenus');
function setupMenus()
{
    $menus = [
        'header' => 'header menu',
    ];

    register_nav_menus($menus);
}

add_action('init', 'register_post_types');
function register_post_types()
{
    register_post_type('news', [
        'label' => 'Новость',
        'labels' => [
            'name' => 'Новость',
            'singular_name' => 'Новость',
            'add_new' => 'Добавить новость',
            'add_new_item' => 'Добавление новости',
            'edit_item' => 'Редактирование новости',
            'new_item' => 'Новая новость',
            'view_item' => 'Смотреть новость',
            'search_items' => 'Искать новость',
            'not_found' => 'Новость не найдена',
            'not_found_in_trash' => 'Новость не найдена в корзине',
        ],
        'description' => 'Собственный тип для новостей',
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_in_menu' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 3,
        'menu_icon' => null,
        //'capability_type'   => 'post',
        //'capabilities'      => 'post',
        //'map_meta_cap'      => null,
        'hierarchical' => false,
        'supports' => ['title', 'editor'], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies' => [],
        'has_archive' => false,
        'rewrite' => true,
        'query_var' => true,
    ]);
}

add_action('init', 'register_product_types');
function register_product_types()
{
    register_post_type('product', [
        'label' => 'Продукт',
        'labels' => [
            'name' => 'Продукт',
            'singular_name' => 'Продукт',
            'add_new' => 'Добавить продукт',
            'add_new_item' => 'Добавление продукта',
            'edit_item' => 'Редактирование продукты',
            'new_item' => 'Новый продукт',
            'view_item' => 'Смотреть продукт',
            'search_items' => 'Искать продукт',
            'not_found' => 'Продукт не найден',
            'not_found_in_trash' => 'Продукт не найден в корзине',
        ],
        'description' => 'Собственный тип для товаров',
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_in_menu' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 4,
        'menu_icon' => null,
        //'capability_type'   => 'post',
        //'capabilities'      => 'post',
        //'map_meta_cap'      => null,
        'hierarchical' => false,
        'supports' => ['title', 'editor'], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies' => [],
        'has_archive' => false,
        'rewrite' => true,
        'query_var' => true,
    ]);
}
