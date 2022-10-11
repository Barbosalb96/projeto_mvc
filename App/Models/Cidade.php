<?php

namespace App\Models;

use App\Helpers\Logs;
use App\Helpers\Util;
use App\Lib\Model;

class Cidade extends Model
{
    protected $table = 'cidades';

    public function getAll()
    {
        return $this->queryExecute($this->all())->fetchAll();
    }

    public function findOfFail($field, $param)
    {
        try {
            $query = $this->select() . $this->where($field, '=', $param);

            $query = $this->queryExecute($query);

            return $query->fetch();
        } catch (\Exception $e) {
            Logs::logMe($e->getMessage());
            return Util::redirect('/user/index');
        }
    }
}