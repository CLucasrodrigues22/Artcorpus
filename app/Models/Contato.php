<?php

namespace App\Models;

use MVC\Model\Model;

class Contato extends Model
{
    private $id;
    private $cep;
    private $logradouro;
    private $complemento;
    private $bairro;
    private $numero;
    private $cidade;
    private $uf;
    private $localizacao;
    private $instagram;
    private $whatsapp;
    private $email;

    public function __get($attr) {
        return $this->$attr;
    }

    public function __set($attr, $value) {
        $this->$attr = $value;
    }

    public function showData()
    {
        $q = "select * from contato where id = 1";
        return $this->db->query($q)->fetch();
    }

    public function create()
    {
        $q = "insert into contato (cep, logradouro, complemento, bairro, numero, cidade, uf, localizacao, instagram, whatsapp, email) values(:cep, :logradouro, :complemento, :bairro, :numero, :cidade, :uf, :localizacao, :instagram, :whatsapp, :email)";
        $stmt = $this->db->prepare($q);
        $stmt->bindValue(':cep', $this->__get('cep'));
        $stmt->bindValue(':logradouro', $this->__get('logradouro'));
        $stmt->bindValue(':complemento', $this->__get('complemento'));
        $stmt->bindValue(':bairro', $this->__get('bairro'));
        $stmt->bindValue(':numero', $this->__get('numero'));
        $stmt->bindValue(':cidade', $this->__get('cidade'));
        $stmt->bindValue(':uf', $this->__get('uf'));
        $stmt->bindValue(':localizacao', $this->__get('localizacao'));
        $stmt->bindValue(':instagram', $this->__get('instagram'));
        $stmt->bindValue(':whatsapp', $this->__get('whatsapp'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();

        return $this;
    }

    public function update($id)
    {
        $q = "update contato set cep = :cep, logradouro = :logradouro, complemento = :complemento, bairro = :bairro, numero = :numero, cidade = :cidade, uf = :uf, localizacao = :localizacao, instagram = :instagram, whatsapp = :whatsapp, email = :email where id = $id";
        $stmt = $this->db->prepare($q);
        $stmt->bindValue(':cep', $this->__get('cep'));
        $stmt->bindValue(':logradouro', $this->__get('logradouro'));
        $stmt->bindValue(':complemento', $this->__get('complemento'));
        $stmt->bindValue(':bairro', $this->__get('bairro'));
        $stmt->bindValue(':numero', $this->__get('numero'));
        $stmt->bindValue(':cidade', $this->__get('cidade'));
        $stmt->bindValue(':uf', $this->__get('uf'));
        $stmt->bindValue(':localizacao', $this->__get('localizacao'));
        $stmt->bindValue(':instagram', $this->__get('instagram'));
        $stmt->bindValue(':whatsapp', $this->__get('whatsapp'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();

        return $this;
    }
}