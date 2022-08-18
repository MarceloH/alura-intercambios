<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
    <link rel="stylesheet" href="<?= get_template_directory_uri() . '/css/normalize.css' ?>">
    <link rel="stylesheet" href="<?= get_template_directory_uri() . '/css/bootstrap.css' ?>">
    <link rel="stylesheet" href="<?= get_template_directory_uri() . '/css/header.css' ?>">
    <link rel="stylesheet" href="<?= get_template_directory_uri() . '/css/' . $estiloPagina ?>">
    <link rel="stylesheet" href="<?= get_template_directory_uri() . '/css/footer.css' ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>

<body <?php body_class(); ?>>
    <header class="site-header">
        <div class="container-alura">
            <?php
            the_custom_logo();
            ?>
            <nav>
                <?php
                wp_nav_menu(
                    array(
                        'menu' => 'menu-navegacao',
                        'menu_id' => 'menu-principal'
                    )
                );
                ?>
            </nav>
        </div>
    </header>