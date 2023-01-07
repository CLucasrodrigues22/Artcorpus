<?php

namespace App\Controllers;

use MVC\Controller\Action;
use MVC\Model\Container;

class ContatoController extends Action
{
    public function index()
    {
        $contatos = Container::getModel('Contato');
        $this->view->contato = $contatos->showData();
        $this->view('private/contato/index', 'layoutPrivate');
    }

    public function setContato()
    {
        try{
            //Gerando link para o whatsapp
            $defaultlinkWpp = 'https://wa.me/';
            $wppPost = $_POST['whatsapp'];
            $wppLink = $defaultlinkWpp . $wppPost;
            // -------- //
            $id = $_GET['id'];
            $contato = Container::getModel('Contato');
            $contato->__set('cep', $_POST['cep']);
            $contato->__set('logradouro', $_POST['logradouro']);
            $contato->__set('complemento', $_POST['complemento']);
            $contato->__set('bairro', $_POST['bairro']);
            $contato->__set('numero', $_POST['numero']);
            $contato->__set('cidade', $_POST['cidade']);
            $contato->__set('uf', $_POST['uf']);
            $contato->__set('localizacao', $_POST['localizacao']);
            $contato->__set('instagram', $_POST['instagram']);
            $contato->__set('whatsapp', $wppLink);
            $contato->__set('email', $_POST['email']);
            if(isset($id) && $id != '')
            {
                $contato->update($id);
                $feedback = 'updatesuccess';
                header("Location: /listdatas?feedback=$feedback");
                exit;
            } else {
                $contato->create();
                $feedback = 'createsuccess';
                header("Location: /listdatas?feedback=$feedback");
                exit;
            }
        }catch(\PDOException $e) {
            if ($e->errorInfo[1]) {
                echo $e;
                //$erro = $e->errorInfo[1];
                //$feedback = 'deleteerror';
                //header("Location: /listservices?feedback=$feedback&error=$erro");
            }
        }
    }
}