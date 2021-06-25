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
$Read->read("usuarios", "WHERE usu_id = '{$add}'");
if ($Read->getResult()):
$recordset = (object) $Read->getResult()[0];
endif;
else:
$CreateUsuario = ["usu_registro" => date('Y-m-d H:i:s')];
$Create->create("usuarios", $CreateUsuario);
header("Location:painel.php?exe=usuarios/create&id={$Create->getResult()}");
exit;
endif;
?>
<div class="box radius bg-white">
    <div class="dashboard_panel dashboard_border_bottom">
        <h1><i class="fa fa-user"> </i>Cadastro de Usuários</h1>
        <div class="clear"></div>
    </div>

    <section class="dashboard_rows">
        <form name="usuarios" class="form-create" method="post" enctype="multipart/form-data">
            <div class="content_form">
                <div class="standard_form">
                    <label class="label-4">
                        <span>Código do Usuário:</span>
                        <input name="usu_id" type="text" class="font_large" placeholder="" readonly required value="<?php echo $recordset->usu_id; ?>">
                        <input type="hidden" name="action" value="update">
                    </label>
                    <label class="label-6">
                        <span>Nome:</span>
                        <input name="usu_nome" type="text" placeholder="..." required="" value="<?php echo $recordset->usu_nome; ?>">
                    </label>

                    <label class="label-3">
                        <span>Filial:</span>
                        <select name="filial_id">
                            <option selected disabled value="">Nenhuma Selecionada</option>
                            <?php
                            $Read->readFull("SELECT * FROM filiais ORDER BY filial_id ASC");
                            $filiais = ($Read->getResult() ? $Read->getResult() : null);

                            if (!empty($filiais)) {
                            foreach ($filiais as $filial) {
                            $filial = (object) $filial;
                            $selected_filial = ($filial->filial_id == $recordset->filial_id) ? "selected='selected'" : '';
                            echo "<option value='{$filial->filial_id}' {$selected_filial}>{$filial->filial_nome}</option>";
                            }
                            }
                            ?>
                        </select>
                    </label>

                    <label class="label-3">
                        <span>Acesso:</span>
                        <select name="usu_level">
                            <option selected disabled value="">Nenhuma Selecionada</option>
                            <?php
                            $Read->readFull("SELECT * FROM levels ORDER BY level_id ASC");
                            $levels = ($Read->getResult() ? $Read->getResult() : null);

                            if (!empty($levels)) {
                            foreach ($levels as $level) {
                            $level = (object) $level;
                            $selected_level = ($level->level_acesso == $recordset->usu_level) ? "selected='selected'" : '';
                            echo "<option value='{$level->level_acesso}' {$selected_level}>{$level->level_nome}</option>";
                            }
                            }
                            ?>
                        </select>
                    </label>

                    <label class="label-3">
                        <span>Data de Nascimento:</span>
                        <input name="usu_nascimento" type="text" class="date" placeholder="" value="<?php echo $recordset->usu_nascimento; ?>">
                    </label>

                    <label class="label-3">
                        <span>E-mail<small> (Login no sistema)</small>:</span>
                        <input name="usu_email" type="email" required="" placeholder="" value="<?php echo $recordset->usu_email; ?>">
                    </label>
                    <label class="label-3">
                        <span>Senha:</span>
                        <input name="usu_password" type="password" required="" placeholder="" value="<?php echo $recordset->usu_password_slug; ?>">
                    </label>
                    <label class="label-3">
                        <span>Celular:</span>
                        <input name="usu_cel" type="text" class="celular_with_ddd" placeholder="" value="<?php echo $recordset->usu_cel; ?>">
                    </label>

                    <label class="label-4">
                        <span>Status:</span>
                        <?php $selected_status = (!empty($recordset->usu_status)) ? (($recordset->usu_status != 0) ? "checked" : "" ) : "";?>
                        <input name="usu_status" type="checkbox" class="font_large" <?php echo $selected_status; ?>  value="1">
                    </label>
                    <label class="label-4">
                        <span>Registro:</span>
                        <input name="usu_registro" type="text" class="datetime" readonly placeholder="" value="<?php echo (!empty($recordset->usu_registro)) ? Check::DataUs($recordset->usu_registro) : ""; ?>">
                    </label>
                    <label class="label-4">
                        <span>Atualização:</span>
                        <input name="usu_alteracao" type="text" class="datetime" readonly placeholder="" value="<?php echo (!empty($recordset->usu_alteracao)) ? Check::DataUs($recordset->usu_alteracao) : ""; ?>">
                    </label>
                    <label class="label-4">
                        <span>Último Acesso:</span>
                        <input name="usu_ultimoacesso" type="text" class="datetime" readonly placeholder="" value="<?php echo (!empty($recordset->usu_ultimoacesso)) ? Check::DataUs($recordset->usu_ultimoacesso) : ""; ?>">
                    </label>
                    <div class="label-1">
                        <button id="myBtn" type="submit" class="btn btn-icon btn-blue radius btn-toggle-form-create"><i class="fa fa-check"></i>Salvar</button><div class="form_load"></div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>