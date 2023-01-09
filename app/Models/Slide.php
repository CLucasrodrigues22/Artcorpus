<?php

namespace App\Models;

use MVC\Model\Model;

class Slide extends Model
{
    private $id;
    private $titulo;
    private $descricao;
    private $imagem;

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
        return $this->db->query($q);
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
}