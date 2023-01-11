<?php

namespace App\Controllers;

// recursos estáticos

use MVC\Controller\Action;
use MVC\Model\Container;

class AuthController extends Action
{
    public function index()
    {
        $this->view('auth/index', 'layoutLogin');
    }

    public function auth()
    {
        $user = Container::getModel('Auth');
        $senha = $_POST['senha'];
        $user->__set('usuario', $_POST['usuario']);
        $userdata = $user->validateUser();

        if (is_array($userdata)) {
            if (password_verify($senha, $userdata['senha'])) {
                session_start();
                $_SESSION = $userdata;
                $feedback = 'sessionstart';
                header("Location: /front?feedback=$feedback");
                exit;
            } else {
                $feedback = 'pwdincorret!';
                header("Location: /authcontrollercontent?feedback=$feedback");
                exit;
            }
        } else {
            $feedback = 'errologin';
            header("Location: /authcontrollercontent?feedback=$feedback");
            exit;
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        $feedback = 'sessionend';
        header("Location: /authcontrollercontent?feedback=$feedback");
        exit;
    }
}
