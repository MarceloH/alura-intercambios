<?php
$estiloPagina = 'projetos.css';
require_once 'header.php';
?>

<form action="#" class="form-inline ml-1">
    <h2>Projetos</h2>
    <div>
        <label for="status">Status</label>
        <select class="form-control" name="status" id="status">
            <option value="">--Selecione--</option>
            <?php
            $status = get_terms(array('taxonomy' => 'status'));

            foreach ($status as $st) : ?>
                <option value="<?= $st->name ?>" <?= !empty($_GET['status']) && $_GET['status'] === $st->name ? 'selected' : '' ?>><?= $st->name ?></option>
            <?php endforeach;
            ?>
        </select>
        <label for="setores">Setores</label>
        <select class="form-control" name="setores" id="setores">
            <option value="">--Selecione--</option>
            <?php
            $setores = get_terms(array('taxonomy' => 'setores'));
            foreach ($setores as $st) : ?>
                <option value="<?= $st->name ?>" <?= !empty($_GET['setores']) && $_GET['setores'] === $st->name ? 'selected' : '' ?>><?= $st->name ?></option>
            <?php endforeach;
            ?>
        </select>
        <input class="btn btn-primary" type="submit" value="Pesquisar">
    </div>
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
    wp_localize_script('config-leaflet-js', 'data', $aProjetos);

    echo '<main class="page-projetos">';
    echo '<div id="map"></div>';
    echo '<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <th>Projeto</th>
                <th>Setor</th>
            </thead>
            <tbody>';
    while ($query->have_posts()) : $query->the_post();
        $titulo = get_the_title();
        $setor =  wp_get_post_terms(get_the_ID(), 'setores', array('fields' => 'names'))[0];
        $link = get_permalink();
        echo "<tr>
                <td><a href=" . $link . ">$titulo</a></td>
                <td>$setor</td>
            </tr>";

    endwhile;
    echo '</tbody>
         </table>
         </main>';
endif;
require_once 'footer.php';
