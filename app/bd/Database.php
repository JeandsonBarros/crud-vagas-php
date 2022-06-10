<?php

namespace App\bd;

use \PDO;
use \PDOException;

class Database
{

    /**
     * Host de conexão com o banco de dados
     * @var string
     */
    const HOST = 'localhost:3306/';

    /**
     * Nome do banco de dados
     * @var string
     */
    const NAME = 'system_vagas';

    /**
     * Usuário do banco
     * @var string
     */
    const USER = 'root';

    /**
     * Senha de acesso ao banco de dados
     * @var string
     */
    const PASS = '';

    /**
     * Nome da tabela a ser manipulada
     * @var string
     */

    /**
     * Nome da tabela a ser manipulada
     * @var string
     */
    private $table;


    /**
     * Instancia de conexão com o banco de dados
     * @var PDO
     */
    private $connection;

    /**
     * Define a tabela e instancia e conexão
     * @param string $table
     */
    public function __construct($table = null)
    {
        $this->table = $table;

        $this->setConection();
    }

    /**
     * Método responsável por criar uma conexão com o banco de dados
     */
    private function setConection()
    {
        try {
            $this->connection = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::NAME, self::USER, self::PASS);

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erro na conexão com o banco de dados: ' . $e->getMessage());
        }
    }


    /**
     * Método responsável por inserir dados no banco
     * @param  array $values [ field => value ]
     * @return integer ID inserido
     */
    public function insert($values)
    {

        //DADOS DA QUERY
        $fields = array_keys($values);
        $binds = array_pad([], count($fields), '?');

        //MONTA A QUERY
        $query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $binds) . ')';


        //EXECUTA O INSERT
        $this->execute($query, array_values($values));

        //RETORNA O ID INSERIDO
        return $this->connection->lastInsertId();
    }

    /**
     * Método responsável por executar atualizações no banco de dados
     * @param  string $where
     * @param  array $values [ field => value ]
     * @return boolean
     */
    public function update($where, $values)
    {
        //DADOS DA QUERY
        $fields = array_keys($values);

        //MONTA A QUERY
        $query = 'update ' . $this->table . ' set ' . implode('=?, ', $fields) . '=? where ' . $where;
        print_r($query);

        $this->execute($query, array_values($values));
    }

    /**
     * Método responsável por executar queries dentro do banco de dados
     * @param  string $query
     * @param  array  $params
     * @return PDOStatement
     */
    public function execute($query, $params = [])
    {
        try {

            $statement = $this->connection->prepare($query);

            $statement->execute($params);

            return $statement;
        } catch (PDOException $e) {
            die('Erro no execute: ' . $e->getMessage());
        }
    }




    /**
     * Método responsável por executar uma consulta no banco
     * @param  string $where
     * @param  string $order
     * @param  string $limit
     * @param  string $fields
     * @return PDOStatement
     */
    public function select($where = null, $order = null, $limit = null, $fields = '*')
    {
        //DADOS DA QUERY
        $where = strlen($where) ? 'where ' . $where : '';
        $order = strlen($order) ? 'order ' . $order : '';
        $limit = strlen($limit) ? 'limit ' . $limit : '';

        //MONTA A QUERY
        $query = 'SELECT ' . $fields . ' FROM ' . $this->table . ' ' . $where . ' ' . $order . ' ' . $limit;

        //EXECUTA A QUERY
        return $this->execute($query);
    }

    /**
     * Método responsável por excluir dados do banco
     * @param  string $where
     * @return boolean
     */
    public function delete($where)
    {   //MONTA A QUERY
        $query = 'delete from ' . $this->table . ' where ' . $where;
      
        //EXECUTA A QUERY
        $this->execute($query);

        //RETORNA SUCESSO
        return true;
    }
}
