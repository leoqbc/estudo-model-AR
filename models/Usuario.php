<?php

/*
 * ATENÇÃO REMOVER ESSA CLASSE!! 
 * Exemplo de classe Model ao extender da Model devemos informar 
 * a tabela que este Active Rocord pertence, apontar o nome da 
 * tabela como protect static $tabela = 'nome da tabela' 
 * Atenção: caso o nome da primary key for diferente de (id) informar 
 * o protected static $id_column = 'cod_cli' por exemplo
 */
namespace ARMODEL\Models;

use ARMODEL\Library\Model;

class Usuario extends Model
{

    protected static $tabela = 'tb_usuarios';
    // protected static $id_column = 'cod_cli'; <- informando um campo ID com nome diferente
    protected function beforeSave()
    {
        echo 'antes de salvar';
    }
}
