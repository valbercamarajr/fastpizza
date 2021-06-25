<?php

require('../../_app/Config.inc.php');
$getPost = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$post = array_map("strip_tags", $getPost);

$action = $post['action'];
$jSon = array();
unset($post['action']);
usleep(400000);

if ($action):
    $Read = new Read;
    $Create = new Create;
    $Update = new Update;
    $Delete = new Delete;
endif;

switch ($action) {
    case 'recuperar_senha':
        $Read->readFull("SELECT * FROM usuarios WHERE usu_email = '{$post['usuario']}'");
        if (!$Read->getResult()):
            $jSon['error'] = "O e-mail <b>{$post['usuario']}</b> não está cadastrado em nosso sistema!";
        else:
            $usu = $Read->getResult()[0];
            $new_password = Check::RandomPass(6);
            $update_recuperarsenha = [
                'usu_password' => md5($new_password),
                'usu_password_slug' => $new_password
            ];
            
            $contato['RemetenteNome'] = 'SeijNet Brasil Administração';
            $contato['RemetenteEmail'] = 'seijnet7@seijnet7.com.br';
            $contato['Assunto'] = 'Recuperação de senha via site.';
            $contato['DestinoNome'] = $usu['usu_nome'];
            $contato['DestinoEmail'] = $usu['usu_email'];
            $contato['Mensagem'] = 'Prezado Sr(a) ' . $usu['usu_nome'] . ',<br> Foi solicitada a reconfiguração da sua senha.<br><br>Nova senha: ' . $new_password . '<br><br>Recomendamos fortemente que proceda a alteração de sua senha no próximo login.';
            
            $SendMail = new Email;
            $SendMail->Enviar($contato);
    
            $Update->update('usuarios', $update_recuperarsenha, "WHERE usu_id = :id", "id={$usu['usu_id']}");
            $jSon['success'] = "Sr(a) <b>{$usu['usu_nome']}</b> sua senha foi resetada e um email foi enviado para <b>{$usu['usu_email']}</b>!";
        endif;
        break;

    case 'update_meusdados':
        $Read->readFull("SELECT * FROM usuarios WHERE usu_email = '{$post['usu_email']}' AND usu_id != '{$post['usu_id']}'");
        if ($Read->getResult()):
            $jSon['error'] = "O e-mail <b>{$post['usu_email']}</b> já está em uso!";
        else:
            $post['usu_nascimento'] = ($post['usu_nascimento'] != '') ? Check::Data($post['usu_nascimento']) : null;

            $update_meusdados = [
                'usu_nome' => $post['usu_nome'],
                'usu_nascimento' => $post['usu_nascimento'],
                'usu_cel' => $post['usu_cel'],
                'usu_email' => $post['usu_email'],
                'usu_alteracao' => date('Y-m-d H:i:s')
            ];

            $Update->update('usuarios', $update_meusdados, "WHERE usu_id = :id", "id={$post['usu_id']}");
            $jSon['success'] = "Sr(a) <b>{$post['usu_nome']}</b>, seu perfil foi atualizado com sucesso!";
        endif;
        break;

    case 'update_mudasenha':
        if ($post['usu_password'] != ($post['usu_password_confirm'])):
            $jSon['error'] = "As senhas não conferem!";
        elseif (strlen($post['usu_password']) < 5):
            $jSon['error'] = "As senhas não podem conter menos de 6 caracteres!";
        else:
            $update_mudasenha = [
                'usu_password' => md5($post['usu_password'])
            ];

            $Update->update('usuarios', $update_mudasenha, "WHERE usu_id = :id", "id={$post['usu_id']}");
            $jSon['success'] = "Sr(a) <b>{$post['usu_nome']}</b>, sua senha foi atualizada com sucesso!";
        endif;

        break;

    case 'delete':
        $Delete->delete('usuarios', "WHERE usu_id = :id", "id={$post['usu_id']}");
        if (!$Delete->getRowCount()) {
            $jSon['error'] = true;
        } else {
            $jSon['success'] = "Usuário excluído com sucesso!";
        }
        break;
}

if (!empty($jSon)) {
    echo json_encode($jSon);
} else {
    $jSon["error"] = true;
    $jSon["errorMsg"] = "501 - Erro ao processar requisição.";
    echo json_encode($jSon);
}