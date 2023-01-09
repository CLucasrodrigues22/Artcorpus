<?php

namespace App\Controllers;

use MVC\Controller\Action;
use MVC\Model\Container;

class DuvidaController extends Action
{
    public function index()
    {
        $duvidas = Container::getModel('Duvida');
        $this->view->dados = $duvidas->showAll();
        $this->view('private/duvida/index', 'layoutPrivate');
    }

    public function create()
    {
        $this->view('private/duvida/create', 'layoutPrivate');
    }

    public function store()
    {
        try {
            $duvida = Container::getModel('Duvida');
            $duvida->__set('titulo', $_POST['titulo']);
            $duvida->__set('duvida', $_POST['duvida']);
            $duvida->create();
            $feedback = 'createsuccess';
            header("Location: /listduvidas?feedback=$feedback");
            exit;
        } catch (\PDOException $e) {
            if ($e->errorInfo[1]) {
                echo $e;
                $erro = $e->errorInfo[1];
                $feedback = 'createerror';
                header("Location: /listduvidas?feedback=$feedback&error=$erro");
            }
        }
    }

    public function show()
    {
        $id = $_GET['id'];
        $duvida = Container::getModel('Duvida');
        $this->view->dados = $duvida->show($id);
        $this->view('private/duvida/show', 'layoutPrivate');
    }

    public function update()
    {
        try {
            $id = $_GET['id'];
            $duvida = Container::getModel('Duvida');
            $duvida->__set('titulo', $_POST['titulo']);
            $duvida->__set('duvida', $_POST['duvida']);
            $duvida->update($id);
            $feedback = 'updatesuccess';
            header("Location: /listduvidas?feedback=$feedback");
            exit;
        } catch (\PDOException $e) {
            if ($e->errorInfo[1]) {
                echo $e;
                $erro = $e->errorInfo[1];
                $feedback = 'updateerror';
                header("Location: /listduvidas?feedback=$feedback&error=$erro");
            }
        }
    }

    public function delete()
    {

        $id = $_GET['id'];
        $duvida = Container::getModel('Duvida');
        $duvida->delete($id);
        $feedback = 'deletesuccess';
        header("Location: /listduvidas?feedback=$feedback");
        exit;
    }
}
