<script src="../_cdn/users.js"></script>
<?php
if (empty($login)) :
    header('Location: ../../painel.php');
    die;
endif;

$search = filter_input_array(INPUT_POST);
if ($search && $search['btn_busca']):
    unset($_POST['btn_busca']);
    $url_search = http_build_query($_POST);
    header("Location:painel.php?exe=users/search&{$url_search}");
    exit;
endif;
?>
<div class="box radius bg-white">
    <div class="dashboard_panel dashboard_border_bottom">
        <h1><i class="fa fa-user"> </i>Usuários</h1>
        <div class="clear"></div>
    </div>

    <section class="dashboard_rows dashboard_list j_list_user">
        <article class="dashboard_rows_header dashboard_border_bottom dashboard_border_top">
            <span class="list_id al-center cell">Código</span>
            <span class="list_des cell">Nome</span>
            <span class="list_actions al-center cell"><a href="painel.php?exe=users/create"><span class="btn btn-sm btn-green radius"><i class="fa fa-check"></i> Novo</span></a></span>
        </article>
        <?php
        $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $Pager = new Pager('painel.php?exe=users/index&page=');
        $Pager->ExePager($getPage, 10);

        $readusers = new Read;
        $readusers->read("users", "ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");

        if ($readusers->getResult()):
            foreach ($readusers->getResult() as $users):
                $users = (object) $users;
                ?>
                <article id="<?php echo "{$users->id}" ?>" class="dashboard_rows_item">
                    <span class="list_id al-center cell"><?php echo $users->id; ?></span>
                    <span class="list_desc cell"><?php echo $users->name; ?></span>
                    <span class="list_actions al-center cell">
                        <a href="painel.php?exe=users/create&id=<?php echo $users->id; ?>" class="btn-actions btn-edit"><i class="fa fa-pen"> </i></a>
                        <button rel="<?php echo $users->id; ?>" class="btn-actions btn-delete j_delete"><i class="fa fa-trash"> </i></button>
                    </span>
                </article>
            <?php
            endforeach;
        endif;
        $Pager->ExePaginator("SELECT * FROM users ORDER BY id DESC ");
        echo $Pager->getPaginator();

        ?>
    </section>
</div>