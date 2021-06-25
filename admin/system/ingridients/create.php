<?php
if (empty($login)) :
    header('Location: ../../painel.php');
    die;
endif;
if (empty($Read)):
    $Read = new Read;
endif;
if (empty($Create)):
    $Create = new Create;
endif;

$add = filter_input(INPUT_GET, 'id');
if ($add <> ''):
    $Read->read("ingridients", " WHERE id = '{$add}'");
    if ($Read->getResult()):
        $recordset = (object) $Read->getResult()[0];
    endif;
else:
    $createIngridient = ["created_at" => date('Y-m-d H:i:s')];
    $Create->create("ingridients", $createIngridient);
    header("Location:painel.php?exe=ingridients/create&id={$Create->getResult()}");
    exit;
endif;
?>
<div class="box radius bg-white">
    <div class="dashboard_panel dashboard_border_bottom">
        <h1><i class="fa fa-pepper-hot"> </i>Cadastro de Ingridientes</h1>
        <div class="clear"></div>
    </div>

    <section class="dashboard_rows">
        <form name="ingridients" class="form-create" method="post" enctype="multipart/form-data">
            <div class="content_form">
                <div class="standard_form">
                    <label class="label-8">
                        <span>Id:</span>
                        <input name="id" type="text" class="font_large" placeholder="" readonly required value="<?php echo $recordset->id; ?>">
                        <input type="hidden" name="action" value="update">
                    </label>
                </div>
                <div class="standard_form">
                    <label class="label-2">
                        <span>Ingrediente</span>
                        <input name="name" type="text" placeholder="..." required="" value="<?php echo $recordset->name; ?>">
                    </label>
                </div>
                <div class="standard_form">
                    <label class="label-8">
                        <span>Valor (R$)</span>
                        <input name="price" type="text" placeholder="..." required="" value="<?php echo $recordset->price; ?>">
                    </label>
                </div>
                <div class="standard_form">
                    <div class="label-1">
                        <button id="myBtn" type="submit" class="btn btn-icon btn-blue radius btn-toggle-form-create"><i class="fa fa-check"></i>Salvar</button><div class="form_load"></div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>