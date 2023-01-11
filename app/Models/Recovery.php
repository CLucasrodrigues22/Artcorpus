<?php

namespace App\Models;

use MVC\Model\Model;

class Recovery extends Model
{
    private $email;
    private $usuario;

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($attr, $value)
    {
        $this->$attr = $value;
    }

    public function validate()
    {
        $q = "select id, nome, usuario from usuarios where email = :email limit 1";
        $stmt = $this->db->prepare($q);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();
        return $stmt->fetch();
    }
}