<?php

namespace App\Models;

use MVC\Model\Model;

class Recovery extends Model
{
    private $id;
    private $email;
    private $rash;
    private $status;

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
        $q = "select * from usuarios where email = :email limit 1";
        $stmt = $this->db->prepare($q);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();
        return $stmt->fetch();
    }

    public function createRecovery()
    {
        $q = "insert into recoverypwd (email, rash) values (:email, :rash)";
        $stmt = $this->db->prepare($q);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':rash', $this->__get('rash'));
        $stmt->execute();
    }
}