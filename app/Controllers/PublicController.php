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
        $slide = Container::getModel('Slide');
        $this->view->slide = $slide->showAll();

        $servico = Container::getModel('Servico');
        $this->view->servico = $servico->showServicos();

        $duvida = Container::getModel('Duvida');
        $this->view->duvida = $duvida->showAll();

        $contato = Container::getModel('Contato');
        $this->view->contato = $contato->showData();

        $this->view('public/index', 'layoutPublic');
    }
}
