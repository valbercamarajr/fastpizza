<?php
require ('_app/Config.inc.php');
$Read = new Read;
$Read->read("pizzas");
$pizzas = $Read->getResult();

?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="assets/_cdn/fonticon.css" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet">
    <link href="assets/_cdn/boot.css" rel="stylesheet" type="text/css"/>
    <link href="assets/_cdn/style.css" rel="stylesheet" type="text/css"/>
    <link rel="apple-touch-icon" sizes="76x76" href="assets/_img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/_img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/_img/favicon-16x16.png">
    <link rel="mask-icon" href="images/safari-pinned-tab.svg" color="#5bbad5">
    <title>Fast Pizza</title>
</head>


<body>
<!--Moda-->
<div class="window content_choose_pizza" id="pizzaModal">
    <a href="#" class="close">x</a>
    <form id="formPizza">
    <p class="tbody"></p>
    <p class="totalOrder"></p>
    <p class="totalDescount"></p>
    <p class="totalOrderWithDescount"></p>
    </form>
</div>
<!--EndModal-->

<header class="main_header">
    <div class="main_header_content">
        <a href="#" class="logo">
            <img src="assets/_img/logo.png" alt="Bem vindo Fast Pizza" title="Bem vindo ao Fast Pizza">
        </a>

        <nav class="main_header_content_menu">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Contato</a></li>
            </ul>
        </nav>

        <nav class="main_header_content_menu_mobile">
            <ul>
                <li><span class="main_header_content_menu_mobile_obj icon-menu icon-notext"></span>
                    <ul class="main_header_content_menu_mobile_sub ds_none">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Contato</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>

<main>

    <section class="main_blog">
        <header class="main_blog_header">
            <h1 class="icon-folder-open">Confira nosso cardápio!</h1>
            <p>Ou, se você preferir monte sua própria pizza.</p>
        </header>
        <?php
            foreach ($pizzas as $pizza){
        ?>
        <article>
            <a href="#">
                <img src="admin/uploads/<?=$pizza['image']?>" width="180" height="180" alt="Lorem Ipsum is simply" title="Lorem Ipsum is simply">
            </a>
            <p><a href='#pizzaModal' class="title" rel='modal' data-id='<?=$pizza['id']?>'><?=$pizza['name']; ?></a></p>
            <h2><a href="#" class="category"><?=$pizza['price'];?></a></h2>
        </article>
        <?php
            }
        ?>
    </section>
</main>

<section class="main_footer">
    <header>
        <h1>Quer saber mais?</h1>
    </header>

    <article class="main_footer_our_pages">
        <header>
            <h2>Nossas Páginas</h2>
        </header>

        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Contato</a></li>
        </ul>
    </article>

    <article class="main_footer_links">
        <header>
            <h2>Links Úteis</h2>
        </header>

        <ul>
            <li><a href="#">Política de Privacidade</a></li>
            <li><a href="#">Aviso Legal</a></li>
            <li><a href="#">Termos de Uso</a></li>
        </ul>
    </article>

    <article class="main_footer_about">
        <header>
            <h2>Sobre a Fast Pizza</h2>
        </header>
        <p>Suspendisse pretium sed class dolor fringilla vel, eros posuere ut eget quam, nunc nostra malesuada sit lobortis. donec felis in ut luctus elementum morbi donec duis.</p>
    </article>
</section>

<footer class="main_footer_rights">
    <p>Todos os Direitos Reservados a Fast Pizza ®</p>
</footer>

<div id="backgroundModal"></div>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>