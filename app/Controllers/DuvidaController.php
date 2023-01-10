<?php

namespace App\Controllers;

use MVC\Controller\Action;
use MVC\Model\Container;

class DuvidaController extends Action
{
    public function index()
    {
        session_start();
        if ($_SESSION['id'] != '')
        {
            $duvidas = Container::getModel('Duvida');
            $this->view->dados = $duvidas->showAll();
            $this->view('private/duvida/index', 'layoutPrivate');
        } else 
        {
            header('Location: /authuserdata?login=erro');
        }
    }

    public function create()
    {
        session_start();
        if ($_SESSION['id'] != '')
        {
            $this->view('private/duvida/create', 'layoutPrivate');
        } else 
        {
            header('Location: /authuserdata?login=erro');
        }
    }

    public function store()
    {
        session_start();
        if ($_SESSION['id'] != '')
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
        } else 
        {
            header('Location: /authuserdata?login=erro');
        }
    }

    public function show()
    {
        session_start();
        if ($_SESSION['id'] != '')
        {
            $id = $_GET['id'];
            $duvida = Container::getModel('Duvida');
            $this->view->dados = $duvida->show($id);
            $this->view('private/duvida/show', 'layoutPrivate');
        } else 
        {
            header('Location: /authuserdata?login=erro');
        }
    }

    public function update()
    {
        session_start();
        if ($_SESSION['id'] != '')
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
        } else 
        {
            header('Location: /authuserdata?login=erro');
        }
    }

    public function delete()
    {
        session_start();
        if ($_SESSION['id'] != '')
        {
            $id = $_GET['id'];
            $duvida = Container::getModel('Duvida');
            $duvida->delete($id);
            $feedback = 'deletesuccess';
            header("Location: /listduvidas?feedback=$feedback");
            exit;
        } else 
        {
            header('Location: /authuserdata?login=erro');
        }
    }
}
