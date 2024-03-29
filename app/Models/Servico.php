<?php

namespace App\Models;

use MVC\Model\Model;

class Servico extends Model
{
    private $id;
    private $nome;
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

    public function showServicos()
    {
        $q = "select * from servicos";
        return $this->db->query($q);
    }

    public function show($id)
    {
        $q = "select * from servicos where id = $id";
        return $this->db->query($q)->fetch();
    }

    public function store()
    {
        $q = "insert into servicos (nome, descricao, imagem) values (:nome, :descricao, :imagem)";
        $stmt = $this->db->prepare($q);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':descricao', $this->__get('descricao'));
        $stmt->bindValue(':imagem', $this->__get('imagem'));
        $stmt->execute();

        return $this;
    }

    public function update($id)
    {
        $q = "update servicos set nome = :nome, descricao = :descricao, imagem = :imagem where id = $id";
        $stmt = $this->db->prepare($q);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':descricao', $this->__get('descricao'));
        $stmt->bindValue(':imagem', $this->__get('imagem'));
        $stmt->execute();

        return $this;
    }

    public function delete($id)
    {
        $q = "delete from servicos where id = $id";
        return $this->db->query($q);
    }
}