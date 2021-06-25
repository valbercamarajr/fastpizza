<script src="../_cdn/pizzas.js"></script>
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
    $Read->read("pizzas", " WHERE id = '{$add}'");
    if ($Read->getResult()):
        $recordset = (object) $Read->getResult()[0];
    endif;
else:
    $createPizza = ["created_at" => date('Y-m-d H:i:s')];
    $Create->create("pizzas", $createPizza);
    header("Location:painel.php?exe=pizzas/create&id={$Create->getResult()}");
    exit;
endif;
?>
<div class="box radius bg-white">
    <div class="dashboard_panel dashboard_border_bottom">
        <h1><i class="fa fa-pizza-slice"> </i>Cadastro de Pizzas</h1>
        <div class="clear"></div>
    </div>

    <section class="dashboard_rows">
        <form name="pizzas" class="form-create" method="post" enctype="multipart/form-data">
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
                        <span>Pizza de...</span>
                        <input name="name" type="text" placeholder="..." required="" value="<?php echo $recordset->name; ?>">
                    </label>
                </div>
                <div class="standard_form">
                    <label class="label-2">
                        <span>Imagem da pizza <small>(Tamanho 200px X 200px)</small>:</span>
                        <span class="file">
                            <input type="file" name="image"/>
                        </span>
                    </label>
                </div>
                <div class="dashboard_row">
                    <div class="standard_form">
                        <label class="label-2">
                            <span>Ingredientes:</span>
                            <div class="list_ingridients_pizza radius">
                                <div class="name_list_ingridient">

                                    <?php
                                        $Read->readFull("SELECT * FROM ingridients ORDER BY name ASC");
                                        $ingridients = ($Read->getResult() ? $Read->getResult() : null);

                                        $Read->readFull("SELECT id_ingridient FROM pizza_ingridients WHERE id_pizza = {$recordset->id}");
                                        $pizza_ingridients = $Read->getResult();

                                        $pi =[];

                                        if ($pizza_ingridients){
                                            foreach($pizza_ingridients as $pizza_ingridient){
                                                $pi[] = $pizza_ingridient['id_ingridient'];
                                            }
                                        }

                                        if(!empty($ingridients)){
                                            foreach ($ingridients as $ingridient) {
                                                $ingridient = (object) $ingridient;
                                                $has_ingridient = in_array($ingridient->id, $pi) ? 'name_list_ingridient_item_active' : '';
                                    ?>
                                        <div class="name_list_ingridient_item j_list_ingredients">
                                                <div id="<?php echo $recordset->id.'_'.$ingridient->id; ?>" class="name_ingridient j_ingridient_pizza <?php echo $has_ingridient; ?>" rel="<?php echo $recordset->id.'_'.$ingridient->id; ?>"><?php echo $ingridient->name . "- R$ " . number_format($ingridient->price, 2,',','.'); ?></div>
                                        </div>
                                    <?php
                                            }
                                        } else {
                                            echo "Ainda não há nenhum ingrediente cadastrado!";
                                        }
                                    ?>

                                </div>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="standard_form">
                    <label class="label-8">
                        <span>Valor da Pizza (R$):</span>
                        <input name="price" type="text" class="font_large" placeholder="" readonly value="<?php echo $recordset->price; ?>">
                    </label>
                </div>
                    <div class="label-1">
                        <button id="myBtn" type="submit" class="btn btn-icon btn-blue radius btn-toggle-form-create"><i class="fa fa-check"></i>Salvar</button><div class="form_load"></div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>