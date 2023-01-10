<?php

namespace App\Controllers;

use MVC\Model\Container;
use MVC\Controller\Action;

class PrivateController extends Action
{
    public function index()
    {
        session_start();
        if ($_SESSION['id'] != '')
        {
            $this->view('private/home/index', 'layoutPrivate');
        } else 
        {
            header('Location: /authuserdata?login=erro');
        }
    }
}