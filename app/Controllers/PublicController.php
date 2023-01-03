<?php

namespace App\Controllers;

// recursos estáticos
use MVC\Controller\Action;
use MVC\Model\Container;

// Model


class PublicController extends Action
{
    public function index()
    {
        $this->view('public/index', 'layoutPublic');
    }
}