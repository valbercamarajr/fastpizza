<?php
ob_start();
require('../_app/Config.inc.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="mit" content="2017-07-17T13:17:34-03:00+3420">
        <title>Site Admin :: Recuperação de Senha</title>

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,800' rel='stylesheet' type='text/css'>        
        <link rel="stylesheet" href="css/boot.css" />
        <link rel="stylesheet" href="css/login.css" />
        
        <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <script src="../_cdn/jquery.js"></script>
        <script src="../_cdn/jquery.form.min.js"></script>
        <script src="../_cdn/system.js"></script>

    </head>
    <body>

        <main>
            <div class="container">
                <div class="box radius">
                    <div class="box_headline">
                        <img src="../admin/images/logo.png">
                    </div>
                    <div class="box_form">
                        <form name="recuperar_senha" class="form-create" method="post" enctype="multipart/form-data">
                            <label>
                                <span>E-mail:</span>
                                <input type="email" class="radius" name="usuario" />
                                <input type="hidden" name="action" value="recuperar_senha" />
                            </label>

                            <button class="radius btn"><i class="fa fa-mail-forward"></i> RECUPERAR SENHA</button><span class="result"></span>
                        </form>
                        <p><a class="esqueceu_senha" href="index.php">Retornar para o login</a></p>
                    </div>

                </div>                
            </div>
        </main>

    </body>
    <script src="../_cdn/jquery.mask.min.js"></script>
    <script src="../_cdn/notification_box.js"></script>
    <script src="../_cdn/confirmation_box.js"></script>
</html>
<?php
ob_end_flush();
