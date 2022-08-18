<?php
$estiloPagina = 'destinos.css';
require_once 'header.php';
?>
<form action="#" class="container-alura formulario-pesquisa">
    <h2>Projetos</h2>
    <select name="status" id="status">
        <option value="">--Selecione--</option>
        <?php
        $status = get_terms(array('taxonomy' => 'status'));

        foreach ($status as $st) : ?>
            <option value="<?= $st->name ?>" <?= !empty($_GET['status']) && $_GET['status'] === $st->name ? 'selected' : '' ?>><?= $st->name ?></option>
        <?php endforeach;
        ?>
    </select>
    <select name="setores" id="setores">
        <option value="">--Selecione--</option>
        <?php
        $setores = get_terms(array('taxonomy' => 'setores'));
        foreach ($setores as $st) : ?>
            <option value="<?= $st->name ?>" <?= !empty($_GET['setores']) && $_GET['setores'] === $st->name ? 'selected' : '' ?>><?= $st->name ?></option>
        <?php endforeach;
        ?>
    </select>
    <input type="submit" value="Pesquisar">
</form>
<?php

if (!empty($_GET['status'])) {
    $statusSelecionado = array(
        'taxonomy' => 'status',
        'field' => 'name',
        'terms' => $_GET['status']
    );
}
if (!empty($_GET['setores'])) {
    $setoresSelecionado = array(
        'taxonomy' => 'setores',
        'field' => 'name',
        'terms' => $_GET['setores']
    );
}

$args = array(
    'post_type' => 'projetos',
    'tax_query' => array(
        'relation' => 'AND',
        !empty($_GET['status']) ? $statusSelecionado : '',
        !empty($_GET['setores']) ? $setoresSelecionado : '',
    )
);
$query = new WP_Query($args);
$aProjetos = [];
if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
        $aProjetos[] = array(
            'titulo' => get_the_title(),
            'latitude' => get_post_meta(get_the_ID(), '_latitude', true),
            'longitude' => get_post_meta(get_the_ID(), '_longitude', true),
            'imagem' => get_taxonomy_image(wp_get_post_terms(get_the_ID(), 'setores', array('fields' => 'ids'))[0])
        );
    endwhile;
    echo '<main class="page-projetos">';
    echo '<div id="map"></div>';
    echo '</main>';
    wp_localize_script('config-leaflet-js', 'data', $aProjetos);
endif;
require_once 'footer.php';
