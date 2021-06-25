<?php
if (empty($login)) :
    header('Location: ../../painel.php');
    die;
endif;
if (empty($Read)):
    $Read = new Read;
endif;
$Read->read("usuarios", "WHERE usu_id = '{$_SESSION['userlogin']['usu_id']}'");
if ($Read->getResult()):
    $recordset = (object) $Read->getResult()[0];
endif;
?>
<div class="box radius bg-white">
    <div class="dashboard_panel dashboard_border_bottom">
        <h1><i class="fa fa-user"> </i>Meu Perfil: <?php echo $recordset->usu_nome; ?></h1>
        <div class="clear"></div>
    </div>

    <section class="dashboard_rows">
        <form name="usuarios" class="form-create" method="post" enctype="multipart/form-data">
            <div class="content_form">
                <div class="standard_form">
                    <label class="label-4">
                        <span>Código do Usuário:</span>
                        <input name="usu_id" type="text" class="font_large" placeholder="" readonly required value="<?php echo $recordset->usu_id; ?>">
                        <input type="hidden" name="action" value="update_meusdados">
                    </label>
                    <label class="label-6">
                        <span>Nome:</span>
                        <input name="usu_nome" type="text" placeholder="..." required="" value="<?php echo $recordset->usu_nome; ?>">
                    </label>

                    <label class="label-2">
                        <span>Filial:</span>
                        <?php
                        $Read->readFull("SELECT * FROM filiais WHERE filial_id = '{$recordset->filial_id}'");
                        $filial = ($Read->getResult() ? $Read->getResult() : null);
                        if (!empty($filial)) {
                            $filial = (object) $Read->getResult()[0];
                        }
                        ?>
                        <input name="filial_nome" type="text" readonly value="<?php echo $filial->filial_nome; ?>">
                        <input name="filial_id" type="hidden" value="<?php echo $recordset->filial_id; ?>">
                    </label>

                    <label class="label-2">
                        <span>Acesso:</span>
                        <?php
                        $Read->readFull("SELECT * FROM levels WHERE level_acesso = '{$recordset->usu_level}'");
                        $level = ($Read->getResult() ? $Read->getResult() : null);
                        if (!empty($level)) {
                            $level = (object) $Read->getResult()[0];
                        }
                        ?>
                        <input name="level_nome" type="text" readonly value="<?php echo $level->level_nome; ?>">
                        <input name="usu_level" type="hidden" value="<?php echo $recordset->usu_level; ?>">
                    </label>

                    <label class="label-3">
                        <span>Data de Nascimento:</span>
                        <input name="usu_nascimento" type="text" class="date" placeholder="" value="<?php echo $recordset->usu_nascimento; ?>">
                    </label>

                    <label class="label-3">
                        <span>E-mail<small> (Login no sistema)</small>:</span>
                        <input name="usu_email" type="email" readonly placeholder="" value="<?php echo $recordset->usu_email; ?>">
                    </label>
                    <label class="label-3">
                        <span>Celular:</span>
                        <input name="usu_cel" type="text" class="celular_with_ddd" placeholder="" value="<?php echo $recordset->usu_cel; ?>">
                    </label>
                    <label class="label-3">
                        <span>Registro:</span>
                        <input name="usu_registro" type="text" class="datetime" readonly placeholder="" value="<?php echo (!empty($recordset->usu_registro)) ? Check::DataUs($recordset->usu_registro) : ""; ?>">
                    </label>
                    <label class="label-3">
                        <span>Atualização:</span>
                        <input name="usu_alteracao" type="text" class="datetime" readonly placeholder="" value="<?php echo (!empty($recordset->usu_alteracao)) ? Check::DataUs($recordset->usu_alteracao) : ""; ?>">
                    </label>
                    <label class="label-3">
                        <span>Último Acesso:</span>
                        <input name="usu_ultimoacesso" type="text" class="datetime" readonly placeholder="" value="<?php echo (!empty($recordset->usu_ultimoacesso)) ? Check::DataUs($recordset->usu_ultimoacesso) : ""; ?>">
                    </label>
                    <div class="label-1">
                        <button id="myBtn" type="submit" class="btn btn-icon btn-red radius btn-toggle-form-create"><i class="fa fa-check"></i>Salvar</button><div class="form_load"></div>
                    </div>
                </div>
            </div>
        </form>
        <div class="standard_form_title">Alterar Senha: </div>
        <div class="content_form">
            <form name="usuarios" class="form-create" method="post" enctype="multipart/form-data">
                <div class="standard_form">
                    <label class="label-3">
                        <span>Senha:</span>
                        <input name="usu_password" type="password" class="font_large" required="" value="">
                        <input name="usu_id" type="hidden" value="<?php echo $recordset->usu_id; ?>">
                        <input name="usu_nome" type="hidden" value="<?php echo $recordset->usu_nome; ?>">
                        <input type="hidden" name="action" value="update_mudasenha">
                    </label>
                    <label class="label-3">
                        <span>Confirma Senha:</span>
                        <input name="usu_password_confirm" type="password" class="font_large" value="">
                    </label>                     
                    <div class="label-1">
                        <button id="myBtn" type="submit" class="btn btn-icon btn-red radius btn-toggle-form-create"><i class="fa fa-lock"></i>Alterar Senha</button><div class="form_load"></div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>