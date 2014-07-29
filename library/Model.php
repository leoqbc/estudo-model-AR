<?php

namespace ARMODEL\Library;

// Este model depende da Classe Banco
class Model {
    protected static $tabela;
    protected static $id_column = 'id';
    public static $status;
    const NOVO  = 1;
    const USADO = 2;

    public function __construct ()
    {
        static::$status = self::NOVO;
    }

    public static function loadModel (\StdClass $res)
    {
        $model = new static();
        static::$status = self::USADO;
        foreach ($res as $prop => $val) {
            $model->$prop = $val;
        }
        return $model;
    }

    public static function getByid($id, $campos='*')
    {
        $db = Banco::instanciar();
        $where = static::$id_column . '=' . $id;
        $res = $db->ver(static::$tabela, $campos,  $where);

        if ($res) {
            return static::loadModel($res);
        }
        return false;
    }

    public static function getAll($campos='*', $where=null)
    {
        $db = Banco::instanciar();
        $results = $db->listar(static::$tabela, $campos, $where);
        if (count ($results)) {
            $id = static::$id_column;
            foreach ($results as $obj) {
                $model = static::loadModel($obj);
                $storage[$model->$id] = $model;
            }
            return $storage;
        }
        return false;
    }

    public function save()
    {
        $db = Banco::instanciar();
        if ($this->validate()) {
            $this->beforeSave();
            if (static::$status === self::USADO) {
                $id = static::$id_column;
                $db->alterar(static::$tabela, $this, $id . '=' . $this->$id);
            }
            if (static::$status === self::NOVO) {
                $db->inserir(static::$tabela, $this);
            }
            $this->afterSave();
            return true;
        }
        return false;
    }

    public function delete()
    {
        $db = Banco::instanciar();
        if (static::$status === self::USADO) {
            $id = static::$id_column;
            $db->apagar(static::$tabela, array($id => $this->$id));
            return true;
        }
        return false;
    }

    /*
    * TODO:
    * Fazer um método fetch para resgatar
    * os objetos um à um deixam assim mais performatico o código
    */
    public function fetch(\PDO $fetchConst)
    {

    }

    protected function beforeSave ()
    {

    }

    protected function afterSave ()
    {

    }

    protected function validate ()
    {
        return true;
    }

}
