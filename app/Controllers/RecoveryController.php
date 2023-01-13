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
        $datas = Container::getModel('Usuario');
        $datas->__set('email', $_POST['email']);
        $datauser = $datas->validateUser();
        if (is_array($datauser)) {
            // Criando uma nova senha
            $newsenha = rand();
            $rashsenha = password_hash($newsenha, PASSWORD_BCRYPT);

            // Enviando e-mail
            $email = $datauser['email'];
            define("sitedir", "https://artcorpus.com.br/", true);
            $destinatario = $email;

            $assunto = "Alteração de senha";
            $headers = "MINE-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $messagem = "<html><head>";
            $messagem .= "
                <h2>Solicitação de nova senha</h2>
                <hr>
                <h3>Segue sua nova senha:</h3><br>
                <p>" . $newsenha . "</p>
                <h4>Essa senha pode ser alterada ao iniciar a sessão!</h4>
                <hr>
                <br>
                Antenciosamente, Art Corpus.
            ";
            $messagem .= "</head></html>";
            if (mail($destinatario, $assunto, $messagem, $headers)) {
                // Salvando nova senha no banco
                $id = $datauser['id'];
                $datas->__set('senha', $rashsenha);
                $datas->updateSenhaEmailRecovery($id);
                $feedback = 'sendpwdsuccess';
                header("Location: /authcontrollercontent?feedback=$feedback");
                exit;
            } else {
                $feedback = 'sendpwderror';
                header("Location: /authcontrollercontent?feedback=$feedback");
                exit;
            }
        } else {
            $feedback = 'useruknown';
            header("Location: /recovery?error=$feedback");
            exit;
        }
    }
}
