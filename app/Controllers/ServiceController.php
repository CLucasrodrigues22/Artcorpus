<?php

namespace App\Controllers;

use MVC\Controller\Action;
use MVC\Model\Container;

class ServiceController extends Action
{
    public function index()
    {
        try {
            $servicos = Container::getModel('Servico');
            $this->view->dados = $servicos->showServicos();
            $this->view('private/skills/index', 'layoutPrivate');
        } catch (\PDOException $e) {
            if ($e->errorInfo[1]) {
                $erro = $e->errorInfo[1];
                $feedback = 'deleteerror';
                header("Location: /listservices?feedback=$feedback&error=$erro");
            }
        }
    }

    public function create()
    {
        try {
            $this->view('private/skills/create', 'layoutPrivate');
        } catch (\PDOException $e) {
            if ($e->errorInfo[1]) {
                $erro = $e->errorInfo[1];
                $feedback = 'deleteerror';
                header("Location: /listservices?feedback=$feedback&error=$erro");
            }
        }
    }

    public function store()
    {
        try {
            $servico = Container::getModel('Servico');

            $upload['diretorio'] = 'storage/servicos/';
            $upload['extensoes'] = ['jpg', 'png'];

            $upload['erros'][0] = 'Não houve erro';
            $upload['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
            $upload['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
            $upload['erros'][3] = 'O upload do arquivo foi feito parcialmente';
            $upload['erros'][4] = 'Não foi feito o upload do arquivo';

            // Tratando e setando imagem
            if ($_FILES['imagem']['name'] != '' && $_FILES['imagem']['error'] === 0) {
                // Dividindo o nome do nome da imagem (imagem . extensão)
                $imagem = explode('.', $_FILES['imagem']['name']);
                // Pegando a extensão da imagem
                $extension = strtolower(end($imagem));
                // Validando Extensão
                if (array_search($extension, $upload['extensoes']) === false) { // percorre array de $upload
                    // se tiver erro >
                    $feedback = 'errorextension';
                    header("Location: /createservice?feedback=$feedback");
                    exit;
                }

                // nome para ser salvo no banco de dados
                $namePhoto = md5($imagem[0]) . '-' . date('YmdHmi') . '.' . $extension;

                // Verifica se é possível mover o arquivo para a pasta escolhida
                if (move_uploaded_file($_FILES['imagem']['tmp_name'], $upload['diretorio'] . $namePhoto)) {
                    $servico->__set('imagem', $namePhoto);
                } else {
                    echo 'Ocorreu o seguinte erro' . $upload['erros'][$_FILES['imagem']['error']];
                }
            }


            // Setando demais atributos
            $servico->__set('nome', $_POST['nome']);
            $servico->store();

            $feedback = 'createsuccess';
            header("Location: /listservices?feedback=$feedback");
            exit;
        } catch (\PDOException $e) {
            if ($e->errorInfo[1]) {
                $erro = $e->errorInfo[1];
                $feedback = 'deleteerror';
                header("Location: /listservices?feedback=$feedback&error=$erro");
            }
        }
    }
}
