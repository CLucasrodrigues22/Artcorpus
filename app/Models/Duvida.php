<?php

namespace App\Models;

use MVC\Model\Model;

class Duvida extends Model
{
    private $id;
    private $titulo;
    private $duvida;

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($attr, $value)
    {
        $this->$attr = $value;
    }

    public function showAll()
    {
        $q = "select * from duvida";
        return $this->db->query($q)->fetchAll();
    }

    public function show($id)
    {
        $q = "select * from duvida where id = $id";
        return $this->db->query($q)->fetch();
    }
    
    public function create()
    {
        $q = "insert into duvida (titulo, duvida) values(:titulo, :duvida)";
        $stmt = $this->db->prepare($q);
        $stmt->bindValue(':titulo', $this->__get('titulo'));
        $stmt->bindValue(':duvida', $this->__get('duvida'));
        $stmt->execute();

        return $this;
    }

    public function update($id)
    {
        $q = "update duvida set titulo = :titulo, duvida = :duvida where id = $id";
        $stmt = $this->db->prepare($q);
        $stmt->bindValue(':titulo', $this->__get('titulo'));
        $stmt->bindValue(':duvida', $this->__get('duvida'));
        $stmt->execute();

        return $this;
    }

    public function delete($id)
    {
        $q = "delete from duvida where id = $id";
        return $this->db->query($q);
    }
}