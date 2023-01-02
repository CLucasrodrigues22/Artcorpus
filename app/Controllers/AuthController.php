<?php

namespace App\Controllers;

// recursos estáticos

use App\Models\Auth;
use MVC\Controller\Action;
use MVC\Init\Bootstrap;
use MVC\Model\Container;

class AuthController extends Action
{
    public function index()
    {
        $this->view('login/login', 'headerOut');
    }

    public function auth()
    {

        $user = Container::getModel('Auth');
        $senha = $_POST['senha'];
        $user->__set('email', $_POST['email']);
        $userdata = $user->validateUser();

        if (is_array($userdata)) {
            if (password_verify($senha, $userdata['senha'])) {
                if ($userdata['status'] == 1) {
                    session_start();
                    $_SESSION = $userdata;
                    $feedback = 'sessionstart';
                    header("Location: /home?feedback=$feedback");
                    exit;
                } else
                {
                    $feedback = 'profiledesatived';
                    header("Location: /?feedback=$feedback");
                    exit;
                }
            } else {
                $feedback = 'pwdincorret!';
                header("Location: /?feedback=$feedback");
                exit;
            }
        } else {
            $feedback = 'errologin';
            header("Location: /?feedback=$feedback");
            exit;
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        $feedback = 'sessionend';
        header("Location: /?feedback=$feedback");
        exit;
    }
}
