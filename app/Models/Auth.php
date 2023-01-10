<?php

namespace App\Models;

use MVC\Model\Model;

class Auth extends Model 
{
    private $id;
    private $nome;
    private $usuario;
    private $senha;
    private $imagem;

    public function __get($attr) {
        return $this->$attr;
    }

    public function __set($attr, $value) {
        $this->$attr = $value;
    }

    // User Validate
    public function validateUser()
    {
        $q = "select * from usuarios where usuario = :usuario";
        // $q = "SELECT
        //         U.id,
        //         U.fullname,
        //         U.email,
        //         U.senha,
        //         U.photo,
        //         P.status,
        //         P.vizualizar,
        //         P.atualizar,
        //         P.cadastrar,
        //         P.deletar,
        //         P.profileName AS profiles
        //         FROM
        //         users U
        //         INNER JOIN profiles P ON U.profile_id = P.id
        //         WHERE
        //         U.email = :email";
        
        $stmt = $this->db->prepare($q);
        $stmt->bindParam(':usuario', $this->__get('usuario'));
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute();

        return $stmt->fetch();
    }
}