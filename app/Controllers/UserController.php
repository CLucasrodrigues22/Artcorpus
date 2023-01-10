<?php

namespace App\Controllers;

// Recursos estáticos
use MVC\Controller\Action;
use MVC\Model\Container;

class UserController extends Action
{
    public function index()
    {
        session_start();
        if ($_SESSION['id'] != '')
        {
            try {
                $usuarios = Container::getModel('Usuario');
                $this->view->usuarios = $usuarios->showUsers();
                $this->view('private/users/index', 'layoutPrivate');
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

    public function create()
    {
        session_start();
        if ($_SESSION['id'] != '')
        {
            try {
                $this->view('private/users/create', 'layoutPrivate');
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

    public function store()
    {
        session_start();
        if ($_SESSION['id'] != '')
        {
            try {
                $usuario = Container::getModel('Usuario');
        
                $upload['diretorio'] = 'storage/users/';
                $upload['extensoes'] = ['jpg', 'png', 'gif'];
        
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
                        header("Location: /createuser?feedback=$feedback");
                        exit;
                    }
        
                    // nome para ser salvo no banco de dados
                    $namePhoto = md5($imagem[0]) . '-' . date('YmdHmi') . '.' . $extension;
        
                    // Verifica se é possível mover o arquivo para a pasta escolhida
                    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $upload['diretorio'] . $namePhoto)) {
                        $usuario->__set('imagem', $namePhoto);
                    } else {
                        echo 'Ocorreu o seguinte erro' . $upload['erros'][$_FILES['imagem']['error']];
                    }
                }
        
                // Setando demais atributos
                $usuario->__set('nome', $_POST['nome']);
                $usuario->__set('usuario', $_POST['usuario']);
                $usuario->__set('senha', password_hash($_POST['senha'], PASSWORD_BCRYPT));
                $usuario->create();
        
                $feedback = 'createsuccess';
                header("Location: /listusers?feedback=$feedback");
                exit;
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

    public function show()
    {
        session_start();
        if ($_SESSION['id'] != '')
        {
            try {
                $id = $_GET['id'];
                $usuario = Container::getModel('Usuario');
                $this->view->dados = $usuario->show($id);
                $this->view('private/users/show', 'layoutPrivate');
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
        
                $usuario = Container::getModel('Usuario');
        
                $upload['diretorio'] = 'storage/users/';
                $upload['extensoes'] = ['jpg', 'png', 'gif'];
        
                $upload['erros'][0] = 'Não houve erro';
                $upload['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
                $upload['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
                $upload['erros'][3] = 'O upload do arquivo foi feito parcialmente';
        
                // Tratando imagem
                if ($_FILES['imagem']['error'] === 0 && $_FILES['imagem']['name'] != '') {
        
                    // Remover foto atual do diretório
                    $imagemOld = $usuario->show($id);
                    $path = $upload['diretorio'] . $imagemOld['imagem'];
                    unlink($path);
        
                    // Dividindo o nome do nome da nova imagem (imagem . extensão)
                    $imagem = explode('.', $_FILES['imagem']['name']);
                    // Pegando a extensão da imagem
                    $extension = strtolower(end($imagem));
                    // Validando Extensão
                    if (array_search($extension, $upload['extensoes']) === false) { // percorre array de $upload
                        // se tiver erro >
                        $feedback = 'Só é aceito arquivos com extensões jpg, png ou gif';
                        header("Location: /showuser?feedback=$feedback&id=$id");
                        exit;
                    }
        
                    // nome para ser salvo no banco de dados
                    $namePhoto = md5($imagem[0]) . '-' . date('YmdHmi') . '.' . $extension;
        
                    // Verifica se é possível mover o arquivo para a pasta escolhida
                    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $upload['diretorio'] . $namePhoto)) {
                        $usuario->__set('imagem', $namePhoto);
                    }
                } else {
                    //reculpera o nome da foto atual caso não foi feito nenhum upload
                    $imagemOld = $usuario->show($id);
                    $usuario->__set('imagem', $imagemOld['imagem']);
                }
        
                // Recuperando senha atual
                $senhaOld = $usuario->show($id);
        
                $usuario->__set('nome', $_POST['nome']);
                $usuario->__set('usuario', $_POST['usuario']);
                $usuario->__set('senha', $senhaOld['senha']);
        
                // Validar condições estabelecidas no model e depois enviando dados atributos setados para o model inserir no banco
                $usuario->update($id);
        
                $feedback = 'updatesuccess';
        
                header("Location: /listusers?feedback=$feedback");
                exit;
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

    public function delete()
    {
        session_start();
        if ($_SESSION['id'] != '')
        {
            try {
                $id = $_GET['id'];
        
                $usuario = Container::getModel('Usuario');
        
                $dir = 'storage/users/';
        
                // Remover foto atual do diretório
                $photoOld = $usuario->show($id);
                $path = $dir . $photoOld['imagem'];
                unlink($path);
        
                // Removendo dados do banco
        
                $usuario->__set('id', $id);
        
                $usuario->delete($id);
        
                $feedback = 'deletesuccess';
        
                header("Location: /listusers?feedback=$feedback");
                exit;
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

    public function alterSenha()
    {
        session_start();
        if ($_SESSION['id'] != '')
        {
            try {
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
}
