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

        // Rotas de Sessão do usuário
            // Rota de formulário de login
            $routes['login'] = array (
                'route' => '/',
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
        $this->setRoutes($routes);
    }
}