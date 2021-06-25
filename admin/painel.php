<?php
ob_start();
session_start();
require('../_app/Config.inc.php');

$login = new Login(3);
$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
$getexe = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);

if (!$login->CheckLogin()):
    unset($_SESSION['userlogin']);
    header('Location: index.php?exe=restrito');
    exit;
else:
    $userlogin = $_SESSION['userlogin'];
endif;

if ($logoff):
    unset($_SESSION['userlogin']);
    header('Location: index.php?exe=logoff');
endif;
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <!--[if lt IE 9]>
            <script src="../_cdn/html5.js"></script> 
         <![endif]-->

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,800' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/boot.css" />
        <link rel="stylesheet" href="css/style.css" />

        <link href="css/fontawesome/css/all.css" rel="stylesheet">
        <link rel="apple-touch-icon" sizes="76x76" href="images/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
        <link rel="manifest" href="images/site.webmanifest">
        <link rel="mask-icon" href="images/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

        <script src="../_cdn/jquery.js"></script>
        <script src="../_cdn/jquery.form.min.js"></script>
        <script src="../_cdn/system.js"></script>
    </head>

    <body>

        <div id="wrapper" class="toggled">

            <!-- Sidebar -->
            <div id="sidebar-wrapper">
                <ul class="sidebar-nav">
                    <li class="sidebar-brand">
                        <a href="./painel.php">
                            <img src="./images/logo_admin.png"/>
                        </a>
                    </li>
                    <?php
                    //ATIVA MENU
                    if (isset($getexe)):
                        $linkto = explode('/', $getexe);
                    else:
                        $linkto = array();
                    endif;
                    ?>
                    <li>
                        <a href="painel.php"><i class="fa fa-laptop"></i>Dashboard</a>
                    </li>
                    <?php if ($_SESSION['userlogin']['level'] > 9) { ?>
                        <li class="<?php if (in_array('pizzas', $linkto)) echo 'active'; ?>">
                            <a href="painel.php?exe=pizzas/index"><i class="fa fa-pizza-slice"></i>Pizzas</a>
                        </li>
                    <?php } ?>
                    <?php if ($_SESSION['userlogin']['level'] > 9) { ?>
                        <li class="<?php if (in_array('ingridients', $linkto)) echo 'active'; ?>">
                            <a href="painel.php?exe=ingridients/index"><i class="fa fa-pepper-hot"></i>Ingredientes</a>
                        </li>
                    <?php } ?>

                    <?php if ($_SESSION['userlogin']['level'] > 9) { ?>
                        <li class="<?php if (in_array('usuarios', $linkto)) echo 'active'; ?>">
                            <a href="painel.php?exe=usuarios/index"><i class="fa fa-user"></i>Usuários</a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="sair.php"><i class="fa fa-door-open"></i>Sair da App</a>
                    </li>
                </ul>
            </div>
            <!-- /#sidebar-wrapper -->

            <!-- Page Content -->
            <div id="page-content-wrapper">
                <div class="page_content_header">
                    <a href="#menu-toggle" class="btn btn-sm btn-toggle radius" id="menu-toggle"><i class="fa fa-bars"></i></a>
                    <?php echo date('d.m.Y'); ?>
                </div>
                <div class="page_content_dashboard">
                    <?php
                    //QUERY STRING
                    if (!empty($getexe)):
                        $includepatch = __DIR__ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . strip_tags(trim($getexe) . '.php');
                    else:
                        //$includepatch = __DIR__ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'home.php';
                        $includepatch = __DIR__ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'pizzas/index.php';
                    endif;

                    if (file_exists($includepatch)):
                        require_once($includepatch);
                    else:
                        echo "<div class=\"content notfound\">";
                        WSErro("<b>Erro ao incluir tela:</b> Erro ao incluir o controller /{$getexe}.php!", WS_ERROR);
                        echo "</div>";
                    endif;
                    ?>
                </div>
            </div>
            <!-- /#page-content-wrapper -->

        </div>
        <!-- /#wrapper -->

        <div id="myModal" data-id="myModal" class="modal wModal">

            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-close">&times;</span>
                    <h2>Modal Header</h2>
                </div>
                <form class="main_form" action="add_appointment" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="standard_form">
                            <label class="label-2">
                                <span>Título do Agendamento:</span>
                                <input name="appointment_title" type="text" class="font_large" placeholder="O que gostaria de agendar?" required>
                            </label>
                            <label class="label-2">
                                <span>Descrição:</span>
                                <textarea rows="4" name="appointment_description"></textarea>
                            </label>

                            <label class="label-2">
                                <span>Localização:</span>
                                <input name="appointment_location" type="text" placeholder="Onde será?">
                            </label>

                            <label class="label-2">
                                <span>E-mail:</span>
                                <input name="appointment_email" type="email" placeholder="Qual o e-mail do participante?">
                            </label>


                            <label class="label-2">
                                <span>Selecione um dia e horário:</span>
                                <select name="appointment_schedule_id">
                                    <option selected disabled value="">Nenhum Selecionado</option>

                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer al-right">
                        <button id="myBtn" class="btn btn-icon btn-sm btn-blue radius modal-open"><i class="fa fa-check"></i>Salvar</button>
                    </div>
                </form>
            </div> 
        </div>

        <div id="myModal2" class="modal wModal">

            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-close">&times;</span>
                    <h2>Modal Header</h2>
                </div>
                <div class="modal-body">
                    <p>A segunda modal</p>
                    <p>Some other text...</p>
                </div>
                <div class="modal-footer al-right">
                    <button id="myBtn" class="btn btn-icon btn-sm btn-blue radius modal-open"><i class="fa fa-hand-o-up"></i>Modal</button>
                    <button id="myBtn" class="btn btn-sm btn-blue radius"><i class="fa fa-hand-o-up"></i>Modal</button>
                    <button id="myBtn" class="btn btn-sm btn-blue radius"><i class="fa fa-hand-o-up"></i>Modal</button>
                    <button id="myBtn" class="btn btn-sm btn-blue radius modal-open"><i class="fa fa-hand-o-up"></i>Modal</button>
                </div>
            </div> 

        </div>

    </body>
    <script src="../_cdn/jquery.mask.min.js"></script>
    <script src="../_cdn/notification_box.js"></script>
    <script src="../_cdn/confirmation_box.js"></script>

</html>
<?php
ob_end_flush();
