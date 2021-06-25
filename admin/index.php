<?php
ob_start();
session_start();
require('./../_app/Config.inc.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="mit" content="2017-07-17T13:17:34-03:00+3420">
        <title>Site Admin</title>

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,800' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/login.css" />

    </head>
    <body>

        <main>
            <div class="container">
                <div class="box radius">
                    <div class="box_headline">
                        <img src="../admin/images/logo.png">
                    </div>
                    <div class="box_form">
                        <?php
                        $login = new Login(3);
                        if ($login->CheckLogin()):
                            header('Location: painel.php');
                        endif;
                        $dataLogin = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                        if (!empty($dataLogin['AdminLogin'])):
                            $login->ExeLogin($dataLogin);
                            if (!$login->getResult()):
                                WSErro($login->getError()[0], $login->getError()[1]);
                            else:
                                header('Location: painel.php');
                            endif;
                        endif;

                        $get = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);
                        if (!empty($get)):
                            if ($get == 'restrito'):
                                WSErro('<b>Oppsss:</b> Acesso negado. Favor efetue login para acessar o painel!', WS_ALERT);
                            elseif ($get == 'logoff'):
                                WSErro('<b>Sucesso ao deslogar:</b> Sua sessão foi finalizada. Volte sempre!', WS_ACCEPT);
                            endif;
                        endif;
                        ?>

                        <form name="LoginForm" action="" method="post">
                            <label>
                                <span>E-mail:</span>
                                <input type="email" class="radius" name="usuario" />
                            </label>

                            <label>
                                <span>Senha:</span>
                                <input type="password" class="radius" name="password" />
                            </label>  
                            <input type="submit" name="AdminLogin" class="radius btn" value="ENTRAR" />
                        </form>
                        <p><a class="esqueceu_senha" href="recuperar-senha.php">Esqueceu a senha?</a></p>
                    </div>

                </div>                
            </div>
        </main>

    </body>
</html>
<?php
ob_end_flush();