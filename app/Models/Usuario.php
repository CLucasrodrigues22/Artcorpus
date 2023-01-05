<?php

namespace App\Models;

use MVC\Model\Model;

class Usuario extends Model
{

    private $id;
    private $nome;
    private $usuario;
    private $senha;
    private $imagem;

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($attr, $value)
    {
        $this->$attr = $value;
    }

    public function showUsers()
    {
        $q = "select id, nome, usuario, imagem from usuarios";
        return $this->db->query($q);
    }

    public function create()
    {
        $q = "insert into usuarios (nome, usuario, senha, imagem) values (:nome, :usuario, :senha, :imagem) ";
        $stmt = $this->db->prepare($q);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':usuario', $this->__get('usuario'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->bindValue(':imagem', $this->__get('imagem'));
        $stmt->execute();

        return $this;
    }

    public function show($id)
    {
        $q = "select * from usuarios where id = $id";
        return $this->db->query($q)->fetch();
    }

    public function update($id)
    {
        $q = "update usuarios set nome = :nome, usuario = :usuario, senha = :senha, imagem = :imagem where id = $id";
        $stmt = $this->db->prepare($q);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':usuario', $this->__get('usuario'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->bindValue(':imagem', $this->__get('imagem'));
        $stmt->execute();

        return $this;
    }
}
