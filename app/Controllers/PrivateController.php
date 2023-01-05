<?php

namespace App\Controllers;

use MVC\Model\Container;
use MVC\Controller\Action;

class PrivateController extends Action
{
    public function index()
    {
        $this->view('private/home/index', 'layoutPrivate');
    }
}