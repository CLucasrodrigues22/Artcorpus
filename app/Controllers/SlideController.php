<?php

namespace App\Controllers;

use MVC\Model\Container;
use MVC\Controller\Action;

class SlideController extends Action
{
    public function index()
    {
        $this->view('private/slide/index', 'layoutPrivate');
    }

    public function create()
    {
        $this->view('private/slide/create', 'layoutPrivate');
    }

    public function store()
    {
        try {
            $slide = Container::getModel('Slide');

            $upload['diretorio'] = 'storage/slides/';
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
                    header("Location: /listslide?feedback=$feedback");
                    exit;
                }

                // nome para ser salvo no banco de dados
                $namePhoto = md5($imagem[0]) . '-' . date('YmdHmi') . '.' . $extension;

                // Verifica se é possível mover o arquivo para a pasta escolhida
                if (move_uploaded_file($_FILES['imagem']['tmp_name'], $upload['diretorio'] . $namePhoto)) {
                    $slide->__set('imagem', $namePhoto);
                } else {
                    echo 'Ocorreu o seguinte erro' . $upload['erros'][$_FILES['imagem']['error']];
                }
            }


            // Setando demais atributos
            $slide->__set('titulo', $_POST['titulo']);
            $slide->__set('descricao', $_POST['descricao']);
            $slide->create();

            $feedback = 'createsuccess';
            header("Location: /listslide?feedback=$feedback");
            exit;
        } catch (\PDOException $e) {
            if ($e->errorInfo[1]) {
                $erro = $e->errorInfo[1];
                $feedback = 'deleteerror';
                header("Location: /listslide?feedback=$feedback&error=$erro");
            }
        }
    }

    public function show()
    {
        
    }

    public function update()
    {

    }
}
