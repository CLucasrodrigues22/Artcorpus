<?php

namespace App\Models;

use MVC\Model\Model;

class Slide extends Model
{
    private $id;
    private $imagem;
    private $titulo;
    private $descricao;

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
        $q = "select * from slide";
        return $this->db->query($q)->fetchAll();
    }

    public function create()
    {
        $q = "insert into slide (imagem, titulo, descricao) values (:imagem, :titulo, :descricao)";
        $stmt = $this->db->prepare($q);
        $stmt->bindValue(':imagem', $this->__get('imagem'));
        $stmt->bindValue(':titulo', $this->__get('titulo'));
        $stmt->bindValue(':descricao', $this->__get('descricao'));
        $stmt->execute();

        return $this;
    }

    public function show($id)
    {
        $q = "select * from slide where id = $id";
        return $this->db->query($q)->fetch();
    }

    public function update($id)
    {
        $q = "update slide set imagem = :imagem, titulo = :titulo, descricao = :descricao where id = $id";
        $stmt = $this->db->prepare($q);
        $stmt->bindValue(':imagem', $this->__get('imagem'));
        $stmt->bindValue(':titulo', $this->__get('titulo'));
        $stmt->bindValue(':descricao', $this->__get('descricao'));
        $stmt->execute();

        return $this;
    }

    public function delete($id)
    {
        $q = "delete from slide where id = $id";
        return $this->db->query($q);
    }
}