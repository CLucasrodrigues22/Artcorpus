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
    private $localidade;
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
}