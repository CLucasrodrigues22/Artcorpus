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
        session_start();
        if ($_SESSION['id'] != '') {
            $slide = Container::getModel('Slide');
            $this->view->slide = $slide->showAll();
            
            $service = Container::getModel('Service');
            $this->view->service = $service->showServicos();

            $duvida = Container::getModel('Duvida');
            $this->view->duvida = $duvida->showAll();

            $usuario = Container::getModel('Usuario');
            $this->view->usuario = $usuario->showUsers();

            $this->view('public/index', 'layoutPublic');
        } else {
            header('Location: /authuserdata?login=erro');
        }
    }
}