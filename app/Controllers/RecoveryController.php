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
        $datauser = $datas->validate();
        echo '<pre>';
        if(is_array($datauser))
        {
            // Enviar Email de reculperação
            //Gerar chave para a alteração da senha
            $key = password_hash($datauser['id'], PASSWORD_DEFAULT);
        } else 
        {
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
        
    }
}   