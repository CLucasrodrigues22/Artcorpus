<?php

namespace App\Controllers;

use MVC\Controller\Action;
use MVC\Model\Container;

class ServiceController extends Action
{
    public function index()
    {
        session_start();
        if ($_SESSION['id'] != '')
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
            try {
                $this->view('private/skills/create', 'layoutPrivate');
            } catch (\PDOException $e) {
                if ($e->errorInfo[1]) {
                    $erro = $e->errorInfo[1];
                    $feedback = 'deleteerror';
                    header("Location: /listservices?feedback=$feedback&error=$erro");
                }
            }
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
                $servico->__set('descricao', $_POST['descricao']);
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
            try {
                $id = $_GET['id'];
                $servico = Container::getModel('Servico');
                $this->view->dados = $servico->show($id);
                $this->view('private/skills/show', 'layoutPrivate');
            } catch (\PDOException $e) {
                if ($e->errorInfo[1]) {
                    $erro = $e->errorInfo[1];
                    $feedback = 'deleteerror';
                    header("Location: /listusers?feedback=$feedback&error=$erro");
                }
            }
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
    
                $servico = Container::getModel('Servico');
    
                $upload['diretorio'] = 'storage/servicos/';
                $upload['extensoes'] = ['png'];
    
                $upload['erros'][0] = 'Não houve erro';
                $upload['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
                $upload['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
                $upload['erros'][3] = 'O upload do arquivo foi feito parcialmente';
    
                // Tratando imagem
                if ($_FILES['imagem']['error'] === 0 && $_FILES['imagem']['name'] != '') {
    
                    // Remover foto atual do diretório
                    $imagemOld = $servico->show($id);
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
                        header("Location: /showservice?feedback=$feedback&id=$id");
                        exit;
                    }
    
                    // nome para ser salvo no banco de dados
                    $namePhoto = md5($imagem[0]) . '-' . date('YmdHmi') . '.' . $extension;
    
                    // Verifica se é possível mover o arquivo para a pasta escolhida
                    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $upload['diretorio'] . $namePhoto)) {
                        $servico->__set('imagem', $namePhoto);
                    }
                } else {
                    //reculpera o nome da foto atual caso não foi feito nenhum upload
                    $imagemOld = $servico->show($id);
                    $servico->__set('imagem', $imagemOld['imagem']);
                }
    
                // Recuperando senha atual
                $senhaOld = $servico->show($id);
    
                $servico->__set('nome', $_POST['nome']);
                $servico->__set('descricao', $_POST['descricao']);
    
                // Validar condições estabelecidas no model e depois enviando dados atributos setados para o model inserir no banco
                $servico->update($id);
    
                $feedback = 'updatesuccess';
    
                header("Location: /listservices?feedback=$feedback");
                exit;
            } catch (\PDOException $e) {
                if ($e->errorInfo[1]) {
                    $erro = $e->errorInfo[1];
                    $feedback = 'deleteerror';
                    header("Location: /listservices?feedback=$feedback&error=$erro");
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
        
                $servico = Container::getModel('Servico');
        
                $dir = 'storage/servicos/';
        
                // Remover foto atual do diretório
                $photoOld = $servico->show($id);
                $path = $dir . $photoOld['imagem'];
                unlink($path);
        
                // Removendo dados do banco
        
                $servico->__set('id', $id);
        
                $servico->delete($id);
        
                $feedback = 'deletesuccess';
        
                header("Location: /listservices?feedback=$feedback");
                exit;
            } catch (\PDOException $e) {
                if ($e->errorInfo[1]) {
                    $erro = $e->errorInfo[1];
                    $feedback = 'deleteerror';
                    header("Location: /listservices?feedback=$feedback&error=$erro");
                }
            }
        } else 
        {
            header('Location: /authuserdata?login=erro');
        }
    }
}
