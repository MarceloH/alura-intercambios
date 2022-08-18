<?php

function alura_intercambios_registrando_taxonomia()
{
    register_taxonomy(
        'paises',
        'destinos',
        array(
            'labels' => array('name' => 'Países'),
            'hierarchical' => true
        )
    );
}

add_action('init', 'alura_intercambios_registrando_taxonomia');

function alura_intercambios_registrando_post_customizado()
{
    register_post_type(
        'destinos',
        array(
            'labels' => array('name' => 'Destinos'),
            'public' => true,
            'menu_position' => 0,
            'supports' => array('title', 'editor', 'thumbnail'),
            'menu_icon' => 'dashicons-admin-site'
        )
    );
}

add_action('init', 'alura_intercambios_registrando_post_customizado');

function alura_intercambios_adicionando_recursos_ao_tema()
{
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'alura_intercambios_adicionando_recursos_ao_tema');

function alura_intercambios_registrando_menu()
{
    register_nav_menu(
        'menu-navegacao',
        'Menu navegação'
    );
}

add_action('init', 'alura_intercambios_registrando_menu');

function alura_intercambios_registrando_post_customizado_banner()
{
    register_post_type(
        'banners',
        array(
            'labels' => array('name' => 'Banner'),
            'public' => true,
            'menu_position' => 1,
            'menu_icon' => 'dashicons-format-image',
            'supports' => array('title', 'thumbnail')
        )
    );
}

add_action('init', 'alura_intercambios_registrando_post_customizado_banner');

function alura_intercambios_registrando_metabox()
{
    add_meta_box(
        'ai_registrando_metabox',
        'Texto para a home',
        'ai_funcao_callback',
        'banners'
    );

    add_meta_box(
        'ai_registrando_metabox_destinos',
        'Campos para destino',
        'ai_funcao_callback_destinos',
        'destinos'
    );

    add_meta_box(
        'ai_registrando_metabox_projetos',
        'Campos para projeto',
        'ai_funcao_callback_projetos',
        'projetos'
    );
}

add_action('add_meta_boxes', 'alura_intercambios_registrando_metabox');

function ai_funcao_callback($post)
{

    $texto_home_1 = get_post_meta($post->ID, '_texto_home_1', true);
    $texto_home_2 = get_post_meta($post->ID, '_texto_home_2', true);
?>
    <label for="texto_home_1">Texto 1</label>
    <input type="text" name="texto_home_1" style="width: 100%" value="<?= $texto_home_1 ?>" />
    <br>
    <br>
    <label for="texto_home_2">Texto 2</label>
    <input type="text" name="texto_home_2" style="width: 100%" value="<?= $texto_home_2 ?>" />
<?php
}

function ai_funcao_callback_destinos($post)
{
    $latitude = get_post_meta(get_the_ID(), '_latitude', true);
    $longitude = get_post_meta(get_the_ID(), '_longitude', true);
?>
    <label for="latitude">Latitude</label>
    <input type="text" name="latitude" style="width: 100%" value="<?= $latitude ?>" required />
    <br>
    <br>
    <label for="longitude">Longitude</label>
    <input type="text" name="longitude" style="width: 100%" value="<?= $longitude ?>" required />
<?php
}

function ai_funcao_callback_projetos($post)
{
    $latitude = get_post_meta(get_the_ID(), '_latitude', true);
    $longitude = get_post_meta(get_the_ID(), '_longitude', true);
?>
    <label for="latitude">Latitude</label>
    <input type="text" name="latitude" style="width: 100%" value="<?= $latitude ?>" required />
    <br>
    <br>
    <label for="longitude">Longitude</label>
    <input type="text" name="longitude" style="width: 100%" value="<?= $longitude ?>" required />
<?php
}

function alura_intercambios_salvando_dados_metabox($post_id)
{
    foreach ($_POST as $key => $value) {
        if ($key !== 'texto_home_1' && $key !== 'texto_home_2' && $key !== 'latitude' && $key !== 'longitude') {
            continue;
        }

        update_post_meta(
            $post_id,
            '_' . $key,
            $_POST[$key]
        );
    }
}

add_action('save_post', 'alura_intercambios_salvando_dados_metabox');

function pegandoTextosParaBanner()
{

    $args = array(
        'post_type' => 'banners',
        'post_status' => 'publish',
        'posts_per_page' => 1
    );

    $query = new WP_Query($args);
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $texto1 = get_post_meta(get_the_ID(), '_texto_home_1', true);
            $texto2 = get_post_meta(get_the_ID(), '_texto_home_2', true);
            return array(
                'texto_1' => $texto1,
                'texto_2' => $texto2
            );
        endwhile;
    endif;
}

function alura_intercambios_adicionando_scripts()
{

    $textosBanner = pegandoTextosParaBanner();

    if (is_front_page()) {
        wp_enqueue_script('typed-js', get_template_directory_uri() . '/js/typed.min.js', array(), false, true);
        wp_enqueue_script('texto-banner-js', get_template_directory_uri() . '/js/texto-banner.js', array('typed-js'), false, true);
        wp_localize_script('texto-banner-js', 'data', $textosBanner);
    } else {
        wp_enqueue_style(
            'leaflet',
            get_template_directory_uri() . '/leaflet/leaflet.css'
        );
        wp_enqueue_script('leaflet-js', get_template_directory_uri() . '/leaflet/leaflet.js', array(), false, true);
        wp_enqueue_script('config-leaflet-js', get_template_directory_uri() . '/leaflet/config-leaflet.js', array('leaflet-js'), false, true);
    }
}

add_action('wp_enqueue_scripts', 'alura_intercambios_adicionando_scripts');


//Projetos

function alura_intercambios_registrando_taxonomia_projetos()
{
    register_taxonomy(
        'status',
        'projetos',
        array(
            'labels' => array('name' => 'Status do projeto'),
            'hierarchical' => true
        )
    );

    register_taxonomy(
        'setores',
        'projetos',
        array(
            'labels' => array('name' => 'Tipo Setores'),
            'hierarchical' => true
        )
    );
}

add_action('init', 'alura_intercambios_registrando_taxonomia_projetos');


function alura_intercambios_registrando_post_customizado_projetos()
{
    register_post_type(
        'projetos',
        array(
            'labels' => array('name' => 'Projetos'),
            'public' => true,
            'menu_position' => 0,
            'supports' => array('title', 'editor', 'thumbnail'),
            'menu_icon' => 'dashicons-open-folder'
        )
    );
}

add_action('init', 'alura_intercambios_registrando_post_customizado_projetos');
