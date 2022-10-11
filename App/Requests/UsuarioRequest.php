<?php

namespace App\Requests;

use App\Helpers\HelperString;
use App\Helpers\Util;

class UsuarioRequest
{
    public static function RequestValidate(array $params): array
    {

        $errors = [];

        if (!Util::helperValidCpf($params['cpf'])) {
            $errors['cpf_invalido'] = 'CPF INVALIDO';
        }

        if (Util::uniqueCpf('cpf', $params['cpf'])) {
            $errors['cpf_existe'] = 'CPF JÁ FOI REGISTRADO';
        }

        if (Util::uniqueEmail('email', $params['email'])) {
            $errors['email_existe'] = 'EMAIL JÁ FOI REGISTRADO';
        }
        if (!Util::existeCidade('id', $params['cidade'])) {
            $errors['cidade_invalida'] = 'VOCÊ TENTOU COLOCAR UMA CIDADE QUE NÃO EXISTE NOS NOSSOS REGISTROS';
        }

        if (!Util::helperValidTel($params['telefone'])) {
            $errors['telefone_invalido'] = 'TELEFONE INVALIDO';
        }


        if ($params['comprovante_name'] == "" || !Util::validTypeDoc($params['comprovante_name'])) {
            $errors['comprovante_invalido'] = 'INFORME O COMPROVATE DE RESIDENCIA VALIDO';
        }

        if (!HelperString::validData($params['data_nascimento'])) {
            $errors['data_nascimento'] = 'INFORME A DATA DE NASCIMENTO CORRETA, ESTE CADASTRO SÓ PODE SER FEITO POR MAIORES DE 26 ANOS';
        }

        return $errors;
    }

    public static function RequestValidateParams(array $params, array $comprovante): array
    {
        $usuario = [];
        $usuario["nome"] = filter_var($params['nome'], FILTER_SANITIZE_SPECIAL_CHARS);

        $usuario["email"] = HelperString::clearEmptySpaceString($params['email']);

        $usuario["telefone"] = HelperString::clearEmptySpaceString(HelperString::clearSymbolsString($params['telefone']));

        $usuario["cpf"] = HelperString::clearEmptySpaceString(HelperString::clearSymbolsString($params['cpf']));

        $usuario["cidade"] = HelperString::clearEmptySpaceString(HelperString::clearSymbolsString($params['cidade']));

        $usuario["data_nascimento"] = $params['data_nascimento'];

        $usuario["cargo"] = HelperString::clearSymbolsString(filter_var($params['cargo'], FILTER_SANITIZE_SPECIAL_CHARS));

        $usuario["comprovante_name"] = $comprovante['name'];

        return $usuario;
    }


}