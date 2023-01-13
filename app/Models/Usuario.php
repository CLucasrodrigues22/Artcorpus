<?php

namespace App\Models;

use MVC\Model\Model;

class Usuario extends Model
{

    private $id;
    private $nome;
    private $usuario;
    private $email;
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

    // Resgata todos os usuários
    public function showUsers()
    {
        $q = "select id, nome, usuario, imagem from usuarios";
        return $this->db->query($q);
    }

    // Insere dados de novo usuários no banco
    public function create()
    {
        $q = "insert into usuarios (nome, usuario, email, senha, imagem) values (:nome, :usuario, :email, :senha, :imagem) ";
        $stmt = $this->db->prepare($q);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':usuario', $this->__get('usuario'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->bindValue(':imagem', $this->__get('imagem'));
        $stmt->execute();

        return $this;
    }

    // Mostra dados do usuários por ID
    public function show($id)
    {
        $q = "select * from usuarios where id = $id";
        return $this->db->query($q)->fetch();
    }

    // Atualiza dados de usuário pelo ID
    public function update($id)
    {
        $q = "update usuarios set nome = :nome, usuario = :usuario, email = :email, senha = :senha, imagem = :imagem where id = $id";
        $stmt = $this->db->prepare($q);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':usuario', $this->__get('usuario'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->bindValue(':imagem', $this->__get('imagem'));
        $stmt->execute();

        return $this;
    }

    // Remove dados do usuário pelo ID
    public function delete($id)
    {
        $q = "delete from usuarios where id = $id";
        return $this->db->query($q);
    }

    // Altera senha do usuário pela sessão
    public function alterPassword($id)
    {
        $q = "update usuarios set senha = :senha where id = $id";
        $stmt = $this->db->prepare($q);
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->execute();

        return $this;
    }

    // Valida e-mail para enviar nova senha para usuário
    public function validateUser()
    {
        $q = "select * from usuarios where email = :email limit 1";
        $stmt = $this->db->prepare($q);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updateSenhaEmailRecovery($id)
    {
        $q = "update usuarios set senha = :senha where id = $id";
        $stmt = $this->db->prepare($q);
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->execute();
    }
}
