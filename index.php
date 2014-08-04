<?php

// Mostrando como funciona a ferramenta
// Só ira funcionar com as tabelas e os campos criados

// header("Content-Type: text/html; charset=UTF8");
namespace ARMODEL\Models;

require 'bootstrap.php';

$user = Usuario::getById(2);
$user = Chat::getById(2);

var_dump($user);