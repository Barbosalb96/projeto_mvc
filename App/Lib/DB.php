<?php
/*
 * @Author Fabio Rocha
 */

namespace App\Lib;

use PDO;
use PDOException;
use Exception;

class DB
{

    public function __construct()
    {
        $oConfigDb = $_SESSION['oConfig']->getConfig()->db;

        $this->host = (!empty($oConfigDb->host)) ? $oConfigDb->host : "";
        $this->name = (!empty($oConfigDb->name)) ? $oConfigDb->name : "";
        $this->username = (!empty($oConfigDb->username)) ? $oConfigDb->username : "";
        $this->password = (!empty($oConfigDb->password)) ? $oConfigDb->password : "";
        $this->driver = (!empty($oConfigDb->driver)) ? $oConfigDb->driver : "";


        $this->pdo = $this->connect();
    }

    protected function connect()
    {

        $pdoConfig = $this->driver . ":" . "host=" . $this->host . ";";
        $pdoConfig .= "dbname=" . $this->name . ";";

        try {
            return new PDO($pdoConfig, $this->username, $this->password);
        } catch (PDOException $e) {
            throw new Exception("Erro de conexão com o banco de dados", 500);
        }
    }

    public function queryExecute($sql, $data_array = null)
    {
        $query = $this->pdo->prepare($sql);
        $exec = $query->execute($data_array);

        if ($exec) {
            return $query;
        } else {
            $error = $query->errorInfo();
            $this->error = $error[2];

            throw new \Exception($this->error);
        }
    }

}