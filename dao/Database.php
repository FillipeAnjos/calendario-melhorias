<?php 

namespace DAO;

class Database {
    
    protected $db;
    protected $order = [];

    /**
     * Representa a instancia a classe,
     * logo nas classes filhas esse atributo
     * deve ser sobrescrito de maneira que
     * mantenha em memória a instância correta
     *
     * @var Class
     * @access protected
     */
    protected static  $oInstance;

    //public function __construct ($dbname = 'melhorias', $host = 'calendariomelhorias_database_1', $port = '5432', $user = 'postgres', $pass = '') 
	public function __construct ($dbname = 'melhorias', $host = 'localhost', $port = '5432', $user = 'postgres', $pass = '11041988') 
    {
        $dsn = "pgsql:dbname={$dbname};host={$host};port={$port}";
        
        $this->db = new \PDO($dsn, $user, $pass);
    }

    /**
     * Retorna a instancia do repositório
     *
     * @return static
     */
    public static function getInstance()
    {
        if (empty(static::$oInstance)) {
            static::$oInstance = new static;
        }

        return static::$oInstance;
    }

    public function filtrarPorId($id, $fields = null)
    {
        $fields = $this->prepareFields($fields);

        $dbst = $this->db->prepare(" SELECT $fields FROM ". static::TABLE ." WHERE id = :id ");
        $dbst->bindValue(':id', $id, \PDO::PARAM_STR);

        return $this->execute($dbst);
    }

    public function filtrarPorDescricao($descricao, $fields = null)
    {
        $fields = $this->prepareFields($fields);
        
        $dbst = $this->db->prepare(" SELECT $fields FROM ". static::TABLE ." WHERE descricao ILIKE :descricao ");
        $dbst->bindValue(':descricao', $descricao, \PDO::PARAM_STR);

        return $this->execute($dbst);
    }

    protected function filtrar ($where, $whereValues, $fields = null)
    {
        $fields = $this->prepareFields($fields);

        $order = null;
        if(!empty($this->order)) {

            $ords = [];
            foreach($this->order as $ord => $dir) {

                $ords[] = "{$ord} {$dir}";
            }

            $order = ' ORDER BY ' . implode(',', $ords);
        }

        $dbst   = $this->db->prepare(" SELECT {$fields} FROM ". static::TABLE ." WHERE {$where} {$order} ");

        if(is_array($whereValues) && !empty($whereValues)) {

            foreach ($whereValues as $param => $value) {

                if(strpos($value, ',') === false) {
                    $typeParam = is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
                    $dbst->bindValue(':'. $param, $value, $typeParam);
                } 
            }
        }

        return $this->execute($dbst);
    }

    public function getAll($limit = null)
    {
        if(!empty($limit)) {
            $limit = ' LIMIT ' . (int)$limit;
        }
        
        $order = null;
        if(!empty($this->order)) {

            $ords = [];
            foreach($this->order as $ord => $dir) {

                $ords[] = "{$ord} {$dir}";
            }

            $order = ' ORDER BY ' . implode(',', $ords);
        }

        $fields = $this->prepareFields();

        return $this->execute($this->db->prepare(" SELECT $fields FROM " . static::TABLE ." {$order} {$limit} "));
    }

    public function order($column, $direction = 'ASC')
    {
        if(!empty($column) && !empty($direction)) {
            $this->order[$column] = $direction;
        }

        return $this;
    }

    protected function execute($dbst)
    {
        $results = $dbst->execute();

        if($results === false) {
            throw new \Exception("Não foi possível executar a consulta\n". implode("\n", $dbst->errorInfo()));
        }

        if($dbst->rowCount() == 0) {
            return null;
        }

        if($dbst->rowCount() == 1) {
            return $dbst->fetchObject();
        }

        $res = [];
        while ($row = $dbst->fetch(\PDO::FETCH_ASSOC, \PDO::FETCH_ORI_NEXT)) {
            $res[] = (object)$row;
        } 

        return $res;
    }

    protected function prepareFields($fields = null)
    {
        if(empty($fields)) {
            $fields = '*';
        } else {

            if(is_array($fields)) {
                $fields = implode(', ', $fields);
            }
        }

        return $fields;
    }

    
    public function __destruct () 
    {
    }

    /* 
        *************************************************************************************************************
        *************************************************************************************************************
        *************************************************************************************************************
    */

    public function insertArea($table, $valor)
    {

        $dbst = $this->db->prepare(" INSERT INTO $table (descricao)VALUES('$valor') ");

        return $this->execute($dbst);
    }

    public function areaJoinMelhorias() 
    {
        $sql = $this->db->prepare(" SELECT 
            ar.id AS areaid, ar.descricao AS areadescricao, me.id AS melhoriasid, 
            me.descricao AS melhoriasdescricao, tarefa, demanda_legal, prazo_acordado, 
            prazo_legal, gravidade, urgencia, tendencia, area 
            FROM area AS ar JOIN melhorias AS me ON ar.id = me.area ORDER BY ar.id ");

        return $this->execute($sql);
    }

    public function buscarAreaId($table, $id) 
    {
        //$sql = $this->db->prepare("select * from $table where id = $id");
        $sql = $this->db->prepare("select * from $table");

        return $this->execute($sql);
    }

    public function buscarTarefaId($table, $id) 
    {
        //$sql = $this->db->prepare("select * from $table where id = $id");
        $sql = $this->db->prepare("select * from $table");

        return $this->execute($sql);
    }

    public function verificarTcA($table, $table2) 
    {
        $sql = $this->db->prepare("SELECT area
            FROM $table AS ar JOIN $table2 AS me
            ON ar.id = me.area
            ORDER BY ar.id");

        return $this->execute($sql);
    }

    public function excluirAreaOrMelhorias($table, $param)  
    {
        $sql = $this->db->prepare(" DELETE FROM $table WHERE id = $param ");

        return $this->execute($sql);
    }

    public function updateEditar($table, $id, $descricao)
    {
        $sql = $this->db->prepare(" UPDATE $table SET descricao = '$descricao' WHERE id = $id ");

        return $this->execute($sql);
    }

    public function updateEditarTarefas($table, $id, $valor)
    {

        /* 
            OBS: Abaixo tem uma sequencia de IF's referente a atualização das tarefas!
            Ao atualizar eu caio na mesma condição de inserir dados 'NULOS' no postgreSQL,
            so que aqui é atualizar dados NULOS.

            No metodo 'insertTarefa()' eu explico o porque tive que fazer essa sequencia de if's, 
            sei que não é a melhor maneira para implementar essa funcionalidade, porém eu tenho que 
            apresentar a vocês um sistema que funcione. 
        */
        
        if($valor[4] == ''){// 4
            $sql = $this->db->prepare(" 
            UPDATE $table SET 
            tarefa = '$valor[0]',
            descricao = '$valor[1]',
            prazo_acordado = CAST('$valor[2]' AS DATE),
            prazo_legal = CAST('$valor[3]' AS DATE),
            gravidade = null,
            urgencia = $valor[5],
            tendencia = $valor[6],
            area = $valor[7]
            WHERE id = $id ");
        }

        if($valor[5] == ''){// 5
            $sql = $this->db->prepare(" 
            UPDATE $table SET 
            tarefa = '$valor[0]',
            descricao = '$valor[1]',
            prazo_acordado = CAST('$valor[2]' AS DATE),
            prazo_legal = CAST('$valor[3]' AS DATE),
            gravidade = $valor[4],
            urgencia = null,
            tendencia = $valor[6],
            area = $valor[7]
            WHERE id = $id ");
        }

        if($valor[6] == ''){// 6
            $sql = $this->db->prepare(" 
            UPDATE $table SET 
            tarefa = '$valor[0]',
            descricao = '$valor[1]',
            prazo_acordado = CAST('$valor[2]' AS DATE),
            prazo_legal = CAST('$valor[3]' AS DATE),
            gravidade = $valor[4],
            urgencia = $valor[5],
            tendencia = null,
            area = $valor[7]
            WHERE id = $id ");
        }

        if($valor[4] == '' && $valor[5] == ''){// 4 5
            $sql = $this->db->prepare(" 
            UPDATE $table SET 
            tarefa = '$valor[0]',
            descricao = '$valor[1]',
            prazo_acordado = CAST('$valor[2]' AS DATE),
            prazo_legal = CAST('$valor[3]' AS DATE),
            gravidade = null,
            urgencia = null,
            tendencia = $valor[6],
            area = $valor[7]
            WHERE id = $id ");
        }

        if($valor[4] == '' && $valor[6] == ''){// 4 6
            $sql = $this->db->prepare(" 
            UPDATE $table SET 
            tarefa = '$valor[0]',
            descricao = '$valor[1]',
            prazo_acordado = CAST('$valor[2]' AS DATE),
            prazo_legal = CAST('$valor[3]' AS DATE),
            gravidade = null,
            urgencia = $valor[5],
            tendencia = null,
            area = $valor[7]
            WHERE id = $id ");
        }

        if($valor[5] == '' && $valor[6] == ''){// 5 6
            $sql = $this->db->prepare(" 
            UPDATE $table SET 
            tarefa = '$valor[0]',
            descricao = '$valor[1]',
            prazo_acordado = CAST('$valor[2]' AS DATE),
            prazo_legal = CAST('$valor[3]' AS DATE),
            gravidade = $valor[4],
            urgencia = null,
            tendencia = null,
            area = $valor[7]
            WHERE id = $id ");
        }

        if($valor[4] != '' && $valor[5] != '' && $valor[6] != ''){//
            $sql = $this->db->prepare(" 
            UPDATE $table SET 
            tarefa = '$valor[0]',
            descricao = '$valor[1]',
            prazo_acordado = CAST('$valor[2]' AS DATE),
            prazo_legal = CAST('$valor[3]' AS DATE),
            gravidade = $valor[4],
            urgencia = $valor[5],
            tendencia = $valor[6],
            area = $valor[7]
            WHERE id = $id ");
        }

        return $this->execute($sql);
    }

    public function insertTarefa($table, $valor)
    {

        /* 
            OBS: Abaixo tenho uma sequencia de IF's referente as varias opções que o usuário pode excolher fazer a inserção das tarefas!
            Tenho como opção somente Gravidade, somente Urgência, somente Tendencia ou somente Gravidade e Urgência e assim por diante ...

            Tentei fazer de outra forma pondo a query no final e dependendo do que o usuário excolher eu botaria o valor NULL na variavél 
            e depois fazia a inserção do valor NULL no banco, porém não sei por qual motivo o banco de dados PostgreSQL só aceita valores 
            nulos se por diretamente dentro da query.

            Ex: de como eu tentei fazer, sem sucesso:
                    
            // ------------------------------------------------

                $valor4 = NULL;
                $valor5 = NULL;
                $valor6 = NULL;

                if($valor[4] != ''){
                    $valor4 = $valor[4];
                }

                if($valor[5] != ''){
                    $valor5 = $valor[5];
                }

                if($valor[6] != ''){
                    $valor6 = $valor[6];
                }

                 $sql = $this->db->prepare(" INSERT INTO $table 
                    (tarefa, descricao, demanda_legal, prazo_acordado, prazo_legal, gravidade, urgencia, tendencia, area)
                    VALUES
                    ('$valor[0]', '$valor[1]', false, CAST('$valor[2]' AS DATE), CAST('$valor[3]' AS DATE), $valor4, $valor5, $valor6, $valor[7] ) ");
            
            // ------------------------------------------------

            Esse é uma das formas que eu faria para funcionar apartir da opção do usuário !
            Essa forma funcionaria no banco de dados MySQL, porém eu não sei por qual motivo no PostgreSQL não funciona, talvez por falta de 
            conhecimento meu, mais eu tinha que apresentar uma aplicação funcional para vocês, não da forma que eu queria apresentar na programação 
            porém está funcional. 

        */

        if($valor[4] == ''){// 4
            $sql = $this->db->prepare(" INSERT INTO $table 
                (tarefa, descricao, demanda_legal, prazo_acordado, prazo_legal, gravidade, urgencia, tendencia, area)
                VALUES
                ('$valor[0]', '$valor[1]', false, CAST('$valor[2]' AS DATE), CAST('$valor[3]' AS DATE), null, $valor[5], $valor[6], $valor[7] ) ");
        }

        if($valor[5] == ''){// 5
            $sql = $this->db->prepare(" INSERT INTO $table 
                (tarefa, descricao, demanda_legal, prazo_acordado, prazo_legal, gravidade, urgencia, tendencia, area)
                VALUES
                ('$valor[0]', '$valor[1]', false, CAST('$valor[2]' AS DATE), CAST('$valor[3]' AS DATE), $valor[4], null, $valor[6], $valor[7] ) ");
        }

        if($valor[6] == ''){// 6
            $sql = $this->db->prepare(" INSERT INTO $table 
                (tarefa, descricao, demanda_legal, prazo_acordado, prazo_legal, gravidade, urgencia, tendencia, area)
                VALUES
                ('$valor[0]', '$valor[1]', false, CAST('$valor[2]' AS DATE), CAST('$valor[3]' AS DATE), $valor[4], $valor[5], null, $valor[7] ) ");
        }

        if($valor[4] == '' && $valor[5] == ''){// 4 5
            $sql = $this->db->prepare(" INSERT INTO $table 
                (tarefa, descricao, demanda_legal, prazo_acordado, prazo_legal, gravidade, urgencia, tendencia, area)
                VALUES
                ('$valor[0]', '$valor[1]', false, CAST('$valor[2]' AS DATE), CAST('$valor[3]' AS DATE), null, null, $valor[6], $valor[7] ) ");
        }

        if($valor[4] == '' && $valor[6] == ''){// 4 6
            $sql = $this->db->prepare(" INSERT INTO $table 
                (tarefa, descricao, demanda_legal, prazo_acordado, prazo_legal, gravidade, urgencia, tendencia, area)
                VALUES
                ('$valor[0]', '$valor[1]', false, CAST('$valor[2]' AS DATE), CAST('$valor[3]' AS DATE), null, $valor[5], null, $valor[7] ) ");
        }

        if($valor[5] == '' && $valor[6] == ''){// 5 6
            $sql = $this->db->prepare(" INSERT INTO $table 
                (tarefa, descricao, demanda_legal, prazo_acordado, prazo_legal, gravidade, urgencia, tendencia, area)
                VALUES
                ('$valor[0]', '$valor[1]', false, CAST('$valor[2]' AS DATE), CAST('$valor[3]' AS DATE), $valor[4], null, null, $valor[7] ) ");
        }

        if($valor[4] != '' && $valor[5] != '' && $valor[6] != ''){//
            $sql = $this->db->prepare(" INSERT INTO $table 
                (tarefa, descricao, demanda_legal, prazo_acordado, prazo_legal, gravidade, urgencia, tendencia, area)
                VALUES
                ('$valor[0]', '$valor[1]', false, CAST('$valor[2]' AS DATE), CAST('$valor[3]' AS DATE), $valor[4], $valor[5], $valor[6], $valor[7] ) ");
        }

        return $this->execute($sql);
    }

}
