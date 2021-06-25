<script src="../_cdn/usuarios.js"></script>
<?php
if (empty($login)) :
    header('Location: ../../painel.php');
    die;
endif;

$search = filter_input_array(INPUT_POST);
if ($search && $search['btn_busca']):
    unset($_POST['btn_busca']);
    $url_search = http_build_query($_POST);
    header("Location:painel.php?exe=usuarios/search&{$url_search}");
    exit;
endif;
?>
<div class="box radius bg-white">
        <div class="dashboard_panel dashboard_border_bottom">
            <h1><i class="fa fa-user"> </i>Usuários</h1>
            <div class="clear"></div>
        </div>
<!--    <section class="dashboard_form_search">
        <form action="painel.php?exe=usuarios/index" id="form_search" name="form_search" method="post">
            <div class="standard_form">
                <label class="label-4">
                    <span>Código</span>
                    <input type="text" id="usu_id" name="usu_id" >
                </label>
                <label class="label">
                    <span>Nome</span>
                    <input type="text" id="usu_nome" name="usu_nome" >
                </label>
                <label class="label-4">
                    <button type="submit" class="btn btn-blue radius btn-search-dashboard" id="btn_busca" name="btn_busca" value="busca">Busca</button>
                    <input type="hidden" id="w_search" name="w_search" value="true"/>
                </label>
            </div>
        </form>
    </section>-->

    <section class="dashboard_rows dashboard_list j_list_usuario">
        <article class="dashboard_rows_header dashboard_border_bottom dashboard_border_top">
            <span class="list_id al-center cell">Código</span><span class="list_desc cell">Nome</span><span class="list_actions al-center cell"><a href="painel.php?exe=usuarios/create"><span class="btn btn-sm btn-green radius"><i class="fa fa-check"></i> Novo</span></a></span>            
        </article>
        <?php
        $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $Pager = new Pager('painel.php?exe=usuarios/index&page=');
        $Pager->ExePager($getPage, 10);

        $readUsuarios = new Read;
        $readUsuarios->read("usuarios", "ORDER BY usu_nome ASC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");

        if ($readUsuarios->getResult()):
            foreach ($readUsuarios->getResult() as $usuario):
                $usuario = (object) $usuario;
                ?>
                <article id="<?php echo "usu_{$usuario->usu_id}" ?>" class="dashboard_rows_item">
                    <span class="list_id al-center cell"><?php echo $usuario->usu_id; ?></span>
                    <span class="list_desc cell"><?php echo $usuario->usu_nome; ?></span>
                    <span class="list_actions al-center cell">
                        <a class="btn-actions btn-add"><i class="fa fa-check"> </i></a>
                        <a href="painel.php?exe=usuarios/create&id=<?php echo $usuario->usu_id; ?>" class="btn-actions btn-edit"><i class="fa fa-pencil"> </i></a>
                        <button rel="<?php echo $usuario->usu_id; ?>" class="btn-actions btn-delete j_delete"><i class="fa fa-trash"> </i></button>
                    </span>
                </article>
                <?php
            endforeach;
        endif;
        $Pager->ExePaginator("usuarios");
        echo $Pager->getPaginator();
        ?>
    </section>
</div>