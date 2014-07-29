<?php
 
class Banco
{
    private static  $instancia;
    private         $conexao;
    public static   $dependencias;

    // Injetor de dependencias
    // Colocar nessa chamada a array de configuração
    // do banco antes de chamar instanciar
    public static function dInjector(array $depends)
    {
        // TODO: Validar aqui se o array está correto
        self::$dependencias = $depends;
    }

    // Esse métodos só permite uma unica
    // conexão no banco mesmo que seja chamada
    // 10 vezes no mesmo arquivo
    public static function instanciar()
    {
        if (is_null(self::$dependencias)) {
            $erro = "Instancia vazia coloque os dados de conexão";
            throw new PDOException($erro, 1);
        }
            
        if(!self::$instancia) {
            self::$instancia = new Banco();
            self::$instancia->conectar();
        }
 
        return self::$instancia;
    }
 
    private function conectar()
    {
        try {
            // Passando as dependencias por fora
            $config = self::$dependencias;
            $this->conexao = new PDO("{$config['driver']}:host={$config['host']};dbname={$config['dbname']}",
                $config['user'], $config['pass']);
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }
     
    private function executar($sql, $dados=null)
    {
        $statement = $this->conexao->prepare($sql);
        $statement->execute($dados);
         
        // SÓ RETORNA PARA OPERAÇÕES DE CONSULTA
        // (nas quais não há dados de entrada)
        if(empty($dados)) {
            return $statement->fetchAll(PDO::FETCH_OBJ);
        }
    }

    public function listar($tabela, $campos='*', $onde=null, $filtro=null, $order=null, $limit=null)
    {
       $query = "SELECT $campos FROM $tabela";

        // TODO: melhorar filtros, deixar mais seguro(placeholder)
        if(!empty($onde)) {
            $query.= " WHERE $onde";
        }
 
        if(!empty($filtro)) {
            $query .= " LIKE '$filtro'";
        }
 
        if(!empty($order)) {
            $query .= " ORDER BY $order";
        }
 
        if(!empty($limit)) {
            $query .= " LIMIT $limit";
        }
 
        return $this->executar($query);
    }
 
    public function ver($tabela, $campos, $onde)
    {
        $query = "SELECT $campos FROM $tabela WHERE $onde LIMIT 1";
 
        $saida = $this->executar($query);
 
        if(isset($saida[0])) {
            return $saida[0];
        }
 
        return false;
    }   
    
    public function inserir($tabela, $dados)
    {
        foreach($dados as $coluna => $valor) {
            $colunas[] = $coluna;
            $holders[] = "?";
            $valores[] = $valor;
        }
         
        $colunas = implode(", ", $colunas);
        $holders = implode(", ", $holders);
 
        $query = "INSERT INTO $tabela ($colunas) VALUES ($holders)";

        $this->executar($query, $valores);
    }
 
    public function alterar($tabela, $dados, $onde)
    {
        foreach($dados as $coluna => $valor) {
            $set[]     = "$coluna=?";
            $valores[] = $valor;
        }
 
        $set = implode(", ", $set);
 
        $query = "UPDATE $tabela SET $set WHERE $onde";
        
        $this->executar($query, $valores);
    }
 
    public function apagar($tabela, $onde)
    {
        foreach($onde as $coluna => $valor) {
            $condicoes[] = "$coluna=?";
            $valores[]   = $valor;
        }
 
        $condicoes = implode(' AND ', $condicoes);
         
        $query = "DELETE FROM $tabela WHERE $condicoes";

        $this->executar($query, $valores);
    }

    public function campos($tabela) 
    {
        $query = $this->conexao->query("DESCRIBE $tabela");
        $query->execute();
        return (object)$query->fetchAll(PDO::FETCH_COLUMN);
    }
}