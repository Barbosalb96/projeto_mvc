<?php

namespace App\Helpers;

use App\Models\Cidade;
use App\Models\Usuario;

class Util
{

    public static function redirect($view)
    {
        header('Location: /' . $view);
    }


    public static function dumpdie($array)
    {
        echo "<pre style='background: black;color: greenyellow'>";
        var_dump($array);
        echo '</pre>';
        die();
    }


    public static function helperValidCpf(string $cpf): bool
    {
        if (strlen($cpf) != 11) {
            return false;
        }

        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    public static function helperValidTel(string $telefone): bool
    {
        $telefone = preg_replace('/[^0-9]/is', '', $telefone);

        if (strlen($telefone) != 11) {
            return false;
        }

        return true;
    }


    public static function uniqueCpf(string $param, string $value): bool
    {
        $query = (new Usuario())->findOfFail($param, $value);

        if (!$query) {
            return false;
        }

        return true;

    }

    public static function uniqueEmail(string $param, string $value): bool
    {
        $query = (new Usuario())->findOfFail($param, "'" . $value . "'");
        if (!$query) {
            return false;
        }

        return true;

    }

    public static function existeCidade(string $param, string $value): bool
    {
        $query = (new Cidade())->findOfFail($param, $value);

        if (!$query) {
            return false;
        }

        return true;

    }


    public static function validTypeDoc($extensaoDoc): bool
    {
        if (!in_array(HelperString::extersaoDoc($extensaoDoc), UpdateDoc::EXTENSOES)) {
            return false;
        }
        return true;
    }


    public static function validParams($params, $fillable): bool
    {
        if (sizeof(array_diff(array_keys($params), $fillable)) > 0) {
            foreach (array_values(array_diff(array_keys($params), $fillable)) as $error) {
                Logs::logMe('Verifiquei os parametros enviados ' . $error);
            }
            return Util::redirect('user/index');
        }
        return true;
    }

}