<?php

namespace App;

use MVC\Init\Bootstrap;

class Route extends Bootstrap {

    // função para iniciar rotas
    protected function initRoutes() {
        
        // Rotas Publicas
            // Index Public
            $routes['/'] = array (
                'route' => '/',
                'controller' => 'PublicController',
                'action' => 'index'
            );

        // Rotas Privadas dos usuários
            // Index do CMS
            $routes['/front'] = array (
                'route' => '/front',
                'controller' => 'PrivateController',
                'action' => 'index'
            );

            // Lista de slides
            $routes['/listslide'] = array (
                'route' => '/listslide',
                'controller' => 'SlideController',
                'action' => 'index'
            );

            // Formulário de slides
            $routes['/createslide'] = array (
                'route' => '/createslide',
                'controller' => 'SlideController',
                'action' => 'create'
            );

            
            // Salvar slides
            $routes['/storeslide'] = array (
                'route' => '/storeslide',
                'controller' => 'SlideController',
                'action' => 'store'
            );

            // Edição de slide
            $routes['/showslide'] = array (
                'route' => '/showslide',
                'controller' => 'SlideController',
                'action' => 'show'
            );

            // Salvar edição de slide
            $routes['/updateslide'] = array (
                'route' => '/updateslide',
                'controller' => 'SlideController',
                'action' => 'update'
            );

            // Deletar slide
            $routes['/deleteslide'] = array (
                'route' => '/deleteslide',
                'controller' => 'SlideController',
                'action' => 'delete'
            );

            // Lista de todas as dúvidas
            $routes['/listduvidas'] = array (
                'route' => '/listduvidas',
                'controller' => 'DuvidaController',
                'action' => 'index'
            );

            // Formulário de cadastro de Dúvida
            $routes['/createduvida'] = array (
                'route' => '/createduvida',
                'controller' => 'DuvidaController',
                'action' => 'create'
            );

            // Salvar dados de dúvida
            $routes['/storeduvida'] = array (
                'route' => '/storeduvida',
                'controller' => 'DuvidaController',
                'action' => 'store'
            );

            // Mostra dados de dúvida
            $routes['/showduvida'] = array (
                'route' => '/showduvida',
                'controller' => 'DuvidaController',
                'action' => 'show'
            );

            // Salvar dados de dúvida
            $routes['/updateduvida'] = array (
                'route' => '/updateduvida',
                'controller' => 'DuvidaController',
                'action' => 'update'
            );

            // Deleta dados de dúvida
            $routes['/deleteduvida'] = array (
                'route' => '/deleteduvida',
                'controller' => 'DuvidaController',
                'action' => 'delete'
            );

            // Lista de todos os usuários
            $routes['/listusers'] = array (
                'route' => '/listusers',
                'controller' => 'UserController',
                'action' => 'index'
            );

            // Formulário de cadastro
            $routes['/createuser'] = array (
                'route' => '/createuser',
                'controller' => 'UserController',
                'action' => 'create'
            );

            // Salvar dados do usuário
            $routes['/storeuser'] = array (
                'route' => '/storeuser',
                'controller' => 'UserController',
                'action' => 'store'
            );

            // Editar Usuario
            $routes['/showuser'] = array (
                'route' => '/showuser',
                'controller' => 'UserController',
                'action' => 'show'
            );

            // Salvar Edição de usuário
            $routes['/updateuser'] = array (
                'route' => '/updateuser',
                'controller' => 'UserController',
                'action' => 'update'
            );

            // Deletar dados do usuário
            $routes['/deleteuser'] = array (
                'route' => '/deleteuser',
                'controller' => 'UserController',
                'action' => 'delete'
            );

            // Alterar Senha do usuário
            $routes['/updatepassword'] = array (
                'route' => '/updatepassword',
                'controller' => 'UserController',
                'action' => 'alterSenha'
            );
            
            // Lista de Todos os serviços
            $routes['/listservices'] = array (
                'route' => '/listservices',
                'controller' => 'ServiceController',
                'action' => 'index'
            );

            // Formulário de criação de serviços
            $routes['/createservice'] = array (
                'route' => '/createservice',
                'controller' => 'ServiceController',
                'action' => 'create'
            );
            
            // Salvar Serviços
            $routes['/storeservice'] = array (
                'route' => '/storeservice',
                'controller' => 'ServiceController',
                'action' => 'store'
            );

            // Lista de servico pelo id
            $routes['/showservice'] = array (
                'route' => '/showservice',
                'controller' => 'ServiceController',
                'action' => 'show'
            );

            // Salva alterações do produto
            $routes['/updateservice'] = array (
                'route' => '/updateservice',
                'controller' => 'ServiceController',
                'action' => 'update'
            );

            // Deletar serviços
            $routes['/deleteservice'] = array (
                'route' => '/deleteservice',
                'controller' => 'ServiceController',
                'action' => 'delete'
            );
            
            // Lista de Dados de contato da empresa
            $routes['/listdatas'] = array (
                'route' => '/listdatas',
                'controller' => 'ContatoController',
                'action' => 'index'
            );

            // Salvar alterações de contato
            $routes['/setContato'] = array (
                'route' => '/setContato',
                'controller' => 'ContatoController',
                'action' => 'setContato'
            );
            

        // Rotas de Sessão do usuário
            // Rota de formulário de login
            $routes['authcontrollercontent'] = array (
                'route' => '/authcontrollercontent',
                'controller' => 'AuthController',
                'action' => 'index'
            );

            // Rota para validar login
            $routes['auth'] = array (
                'route' => '/auth',
                'controller' => 'AuthController',
                'action' => 'auth'
            );

            // Rota para encerrar sessão
            $routes['logout'] = array (
                'route' => '/logout',
                'controller' => 'AuthController',
                'action' => 'logout'
            ); 
            
        // Rotas para recuperação de senha
            // Fomulário de reculperação
            $routes['recovery'] = array (
                'route' => '/recovery',
                'controller' => 'RecoveryController',
                'action' => 'index'
            );

            // Valida e envia email de reculperação
            $routes['recoverypwd'] = array (
                'route' => '/recoverypwd',
                'controller' => 'RecoveryController',
                'action' => 'validate'
            );

            // Formulario de atualização de senha
            $routes['updatepwd'] = array (
                'route' => '/updatepwd',
                'controller' => 'RecoveryController',
                'action' => 'formUpdate'
            );

            // Salvar nova senha
            $routes['storenewpwd'] = array (
                'route' => '/storenewpwd',
                'controller' => 'RecoveryController',
                'action' => 'update'
            );

        $this->setRoutes($routes);
    }
}