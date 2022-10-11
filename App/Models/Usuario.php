<?php

namespace App\Models;

use App\Helpers\Logs;
use App\Helpers\Util;
use App\Lib\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'cpf',
        'data_nascimento',
        'cargo',
        'id_cidade'
    ];

    public function getAll()
    {
        try {
            $query = $this->queryExecute($this->select(
                    'usuarios.id,usuarios.nome,usuarios.email,usuarios.cpf,usuarios.telefone') .
                $this->cidade());

            return $query->fetchAll();

        } catch (\Exception $e) {
            Logs::logMe($e->getMessage());
            return Util::redirect('/user/index');
        }
    }

    public function save($params)
    {
        try {

          Util::validParams($params,$this->fillable);

            $response = $this->create($params);

            if (!$response) {
                return ['error' => 'error ao salvar'];
            }

            $query = self::findOfFail('cpf', $params['cpf']);

            return $query;


        } catch (\Exception $e) {
            Logs::logMe($e->getMessage());
            return Util::redirect('/user/index');
        }
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

    public function findDetail($field, $param)
    {
        try {

            $query = $this->select(
                    "usuarios.*,cidades.nome as cidade"
                ) . $this->cidade() . $this->where($field, '=', $param);


            $query = $this->queryExecute($query);

            $response = $query->fetch();

            if (empty($response)) {
                return Util::redirect('error/404');
            }
            return $response;
        } catch (\Exception $e) {
            Logs::logMe($e->getMessage());
            return Util::redirect('/user/index');
        }
    }


    public function updateFile($file, $userId)
    {
        try {
            $this->update($file, $userId);
            return true;

        } catch (\Exception $e) {
            Logs::logMe($e->getMessage());
            return Util::redirect('/user/index');
        }
    }

    public function delete($column, $value)
    {
        try {
            $this->destroy($column, $value);
            return true;

        } catch (\Exception $e) {
            Logs::logMe($e->getMessage());
            return Util::redirect('/user/index');
        }
    }


    public function cidade()
    {
        return $this->join('cidades', 'id_cidade', 'id');
    }


    public static function getAttributeCpf($value)
    {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $value);
    }

    public static function getAttributeTelefone($value)
    {
        preg_match('/^([0-9]{2})([0-9]{4,5})([0-9]{4})$/', $value, $telefone);
        if ($telefone) {
            return '(' . $telefone[1] . ') ' . $telefone[2] . '-' . $telefone[3];
        }
    }

}