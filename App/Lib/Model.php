<?php

namespace App\Lib;

use App\Helpers\HelperString;
use App\Helpers\Logs;
use App\Helpers\Util;

/**
 * Modelo para crição das query
 */
class Model extends DB
{
    protected $table = '';
    protected $fillable = [];


    /**
     * @param $table
     * @return string
     * Modelo para select das query caso deseje pegar campos expecificos informe as colunas
     */
    protected function all()
    {
        return "SELECT * FROM {$this->table}";

    }

    /**
     * @param $table
     * @return string
     * Modelo para select das query caso deseje pegar campos expecificos informe as colunas
     */
    protected function select($columns = '*')
    {

        return 'SELECT ' . $columns . ' FROM ' . $this->table;
    }

    /**
     * @param $param
     * @param $order
     * @return string
     * Modelo para ordernar consultas
     */
    protected function orderBy($param, $order)
    {
        return ' ORDER BY ' . $param . ' ' . $order;
    }

    /**
     * @param $param
     * @param $action
     * @param $valeu
     * @return string
     * modelo para consultar dados expeficos
     */
    protected function where($param, $action = '=', $valeu)
    {
        return ' where ' . $this->table . "." . $param . ' ' . $action . ' ' . $valeu;
    }


    /**
     * @param $table
     * @param $columns
     * @param $values
     * @return string
     *  Modelo de inserção de dados
     */
    protected function create($params)
    {
        try {

            $query = "INSERT INTO $this->table (" . self::formatColumns($params) . " ) VALUES (" . self::formatValue($params) . ")";

            $insert = $this->queryExecute($query);
            if ($insert) {
                if (method_exists($this->pdo, 'lastInsertId') && $this->pdo->lastInsertId()) {
                    $this->last_id = $this->pdo->lastInsertId();
                }
                return true;
            }

            return false;
        } catch (\Exception $e) {
            Logs::logMe('Verifiquei os parametros enviados ' . array_diff(array_keys($params), $this->fillable));
            Logs::logMe($e->getMessage());
            return Util::redirect('user/index');
        }

    }


    /**
     * @param $table
     * @param $id
     * @return false|\PDOStatement
     * @throws \Exception
     * Necessattio enviar a table ,coluna e valor
     */
    protected function destroy($column, $value)
    {
        $query = "DELETE FROM $this->table WHERE $column = " . $value;
        return $this->queryExecute($query);
    }

    /**
     * @param $table
     * @param $values
     * @param $id
     * @return void
     * @throws \Exception
     * update de dados
     */
    protected function update($values, $id)
    {
        $query = "UPDATE {$this->table} SET {$values['column']} = '{$values['value']}' WHERE id = $id";
        return $this->queryExecute($query);

    }

    protected function join($related, $localKey, $foreignKey)
    {
        return " inner join {$related} on {$this->table}.$localKey = {$related}.$foreignKey ";
    }

    /**
     * @param $params
     * @return string
     * Helper para formatar colunas da base
     */
    protected static function formatColumns($params)
    {
        return HelperString::columnsStringQuery($params);
    }


    /**
     * @param $params
     * @return string
     * helper para formatar valores a serem inseridos
     */
    protected static function formatValue($params)
    {
        return '"' . HelperString::paramsStringQuery($params) . '"';
    }


}