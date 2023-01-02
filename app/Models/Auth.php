<?php

namespace App\Models;

use MVC\Model\Model;

class Auth extends Model 
{
    private $id;
    private $profile_id;
    private $fullname;
    private $email;
    private $senha;
    private $photo;

    public function __get($attr) {
        return $this->$attr;
    }

    public function __set($attr, $value) {
        $this->$attr = $value;
    }

    // User Validate
    public function validateUser()
    {
        //$q = "select * from users where email = :email";
        $q = "SELECT
                U.id,
                U.fullname,
                U.email,
                U.senha,
                U.photo,
                P.status,
                P.vizualizar,
                P.atualizar,
                P.cadastrar,
                P.deletar,
                P.profileName AS profiles
                FROM
                users U
                INNER JOIN profiles P ON U.profile_id = P.id
                WHERE
                U.email = :email";
        
        $stmt = $this->db->prepare($q);
        $stmt->bindParam(':email', $this->__get('email'));
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute();

        return $stmt->fetch();
    }
}