<?php

namespace App\Controllers;

use MVC\Model\Container;
use MVC\Controller\Action;

class SlideController extends Action
{
    public function index()
    {
        session_start();
        if ($_SESSION['id'] != '')
        {
            $slide = Container::getModel('Slide');
            $this->view->dados = $slide->showAll();
            $this->view('private/slide/index', 'layoutPrivate');
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
            $this->view('private/slide/create', 'layoutPrivate');
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
            $slide = Container::getModel('Slide');
            $this->view->dados = $slide->show($id);
            $this->view('private/slide/show', 'layoutPrivate');
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
    
                $slide = Container::getModel('Slide');
    
                $upload['diretorio'] = 'storage/slides/';
                $upload['extensoes'] = ['png'];
    
                $upload['erros'][0] = 'Não houve erro';
                $upload['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
                $upload['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
                $upload['erros'][3] = 'O upload do arquivo foi feito parcialmente';
    
                // Tratando imagem
                if ($_FILES['imagem']['error'] === 0 && $_FILES['imagem']['name'] != '') {
    
                    // Remover foto atual do diretório
                    $imagemOld = $slide->show($id);
                    $path = $upload['diretorio'] . $imagemOld['imagem'];
                    unlink($path);
    
                    // Dividindo o nome do nome da nova imagem (imagem . extensão)
                    $imagem = explode('.', $_FILES['imagem']['name']);
                    // Pegando a extensão da imagem
                    $extension = strtolower(end($imagem));
                    // Validando Extensão
                    if (array_search($extension, $upload['extensoes']) === false) { // percorre array de $upload
                        // se tiver erro >
                        $feedback = 'Só é aceito arquivos com extensões png';
                        header("Location: /showslide?feedback=$feedback&id=$id");
                        exit;
                    }
    
                    // nome para ser salvo no banco de dados
                    $namePhoto = md5($imagem[0]) . '-' . date('YmdHmi') . '.' . $extension;
    
                    // Verifica se é possível mover o arquivo para a pasta escolhida
                    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $upload['diretorio'] . $namePhoto)) {
                        $slide->__set('imagem', $namePhoto);
                    }
                } else {
                    //reculpera o nome da foto atual caso não foi feito nenhum upload
                    $imagemOld = $slide->show($id);
                    $slide->__set('imagem', $imagemOld['imagem']);
                }
    
                $slide->__set('titulo', $_POST['titulo']);
                $slide->__set('descricao', $_POST['descricao']);
    
                // Validar condições estabelecidas no model e depois enviando dados atributos setados para o model inserir no banco
                $slide->update($id);
    
                $feedback = 'updatesuccess';
    
                header("Location: /listslide?feedback=$feedback");
                exit;
            } catch (\PDOException $e) {
                if ($e->errorInfo[1]) {
                    $erro = $e->errorInfo[1];
                    $feedback = 'deleteerror';
                    header("Location: /listslide?feedback=$feedback&error=$erro");
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
            try {
                $id = $_GET['id'];
        
                $slide = Container::getModel('Slide');
        
                $dir = 'storage/slides/';
        
                // Remover foto atual do diretório
                $photoOld = $slide->show($id);
                $path = $dir . $photoOld['imagem'];
                unlink($path);
        
                // Removendo dados do banco
        
                $slide->__set('id', $id);
        
                $slide->delete($id);
        
                $feedback = 'deletesuccess';
        
                header("Location: /listslide?feedback=$feedback");
                exit;
            } catch (\PDOException $e) {
                if ($e->errorInfo[1]) {
                    $erro = $e->errorInfo[1];
                    $feedback = 'deleteerror';
                    header("Location: /listslide?feedback=$feedback&error=$erro");
                }
            }
        } else 
        {
            header('Location: /authuserdata?login=erro');
        }
    }
}
