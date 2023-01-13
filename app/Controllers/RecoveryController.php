<?php

namespace App\Controllers;

use MVC\Controller\Action;
use MVC\Model\Container;

class RecoveryController extends Action
{
    public function index()
    {
        $this->view('auth/recovery', 'layoutLogin');
    }

    public function validate()
    {
        $datas = Container::getModel('Recovery');
        $datas->__set('email', $_POST['email']);
        $datauser = $datas->validateUser();
        if (is_array($datauser)) {
            // Criando rash para alterar a senha
            $rash = password_hash($datauser['id'], PASSWORD_BCRYPT);
            $email = $datauser['email'];
            // Setando attr para enviar para a tabela recoverypwd
            $datas->__set('email', $email);
            $datas->__set('rash', $rash);
            $datas->createRecovery();
            // Enviando e-mail
            define("sitedir", "https://artcorpus.com.br/", true);
            $destinatario = $email;
            $cript = $rash;

            $assunto = "RECUPERAR SENHA";
            $headers = "MINE-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $messagem = "<html><head>";
            $messagem .= "
                <h2>Solicitação de alteração de senha</h2>
                <hr>
                <h3>Link para alterar senha: <a href='" . sitedir . "updatepwd?email=$email&rash=$cript'>" . sitedir . "updatepwd?email=$email&rash=$rash</a></h3>
                <hr>
                <br>
                Antenciosamente, Art Corpus.
            ";
            $messagem .= "</head></html>";
            if (mail($destinatario, $assunto, $messagem, $headers)) {
                $feedback = 'sendmailsuccess';
                header("Location: /authcontrollercontent?feedback=$feedback");
                exit;
            } else {
                $feedback = 'sendmailerror';
                header("Location: /authcontrollercontent?feedback=$feedback");
                exit;
            }
        } else {
            $feedback = 'useruknown';
            header("Location: /recovery?error=$feedback");
            exit;
        }
    }

    public function formUpdate()
    {
        $this->view('auth/updateSenha', 'layoutLogin');
    }

    public function update()
    {
        // Verificar se rash existe no banco
        $rash = $_GET['rash'];
        $datas = Container::getModel('Recovery');
        $datas->__set('rash', $rash);
        $result = $datas->rashVerify();

        if(is_array($result))
        {
            echo 'rash ok';
        } else {
            $feedback = 'rashinvalid';
            header("Location: /authcontrollercontent?feedback=$feedback");
            exit;
        }

    }
}
