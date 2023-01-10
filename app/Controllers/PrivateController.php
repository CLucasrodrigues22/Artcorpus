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
            $slide = Container::getModel('Slide');
            $this->view->slide = $slide->showAll();
            
            $servico = Container::getModel('Servico');
            $this->view->servico = $servico->showServicos();

            $duvida = Container::getModel('Duvida');
            $this->view->duvida = $duvida->showAll();

            $usuario = Container::getModel('Usuario');
            $this->view->usuario = $usuario->showUsers();

            $this->view('private/home/index', 'layoutPrivate');
        } else 
        {
            header('Location: /authcontrollercontent?login=erro');
        }
    }
}