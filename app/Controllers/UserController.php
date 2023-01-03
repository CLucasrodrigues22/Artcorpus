<?php

namespace App\Controllers;

// Recursos estáticos
use MVC\Controller\Action;
use MVC\Model\Container;

class UserController extends Action
{
    public function index()
    {
        $usuarios = Container::getModel('Usuario');
        $this->view->usuarios = $usuarios->showUsers();
        $this->view('private/users/index', 'layoutPrivate');
    }
    
    public function create()
    {
        $this->view('private/users/create', 'layoutPrivate');
    }

    public function store()
    {
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
    }
}
