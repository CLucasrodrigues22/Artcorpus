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