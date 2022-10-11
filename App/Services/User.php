<?php

namespace App\Services;

use App\Helpers\HelperString;
use App\Helpers\UpdateDoc;
use App\Helpers\Util;
use App\Models\Usuario;
use App\Requests\UsuarioRequest;

class User
{
    protected $user;

    public function __construct()
    {
        $this->user = (new Usuario());
    }

    public function all(): array
    {
        return $this->user->getAll();
    }

    public function save($params, $comprovante)
    {

        $usuario = UsuarioRequest::RequestValidateParams($params, $comprovante);

        if (sizeof(UsuarioRequest::RequestValidate($usuario)) > 0) {
            return UsuarioRequest::RequestValidate($usuario);
        }

        $usuario = $this->user->save(
            [
                "nome" => $usuario["nome"],
                'email' => $usuario["email"],
                'telefone' => $usuario['telefone'],
                'cpf' => $usuario['cpf'],
                'data_nascimento' => $usuario['data_nascimento'],
                'cargo' => $usuario['cargo'],
                'id_cidade' => $usuario['cidade']
            ]
        );


        UpdateDoc::updateDoc($comprovante, $usuario['id'], $usuario['cpf']);

        return ['success' => 'Registro salvo', 'user' => $usuario];
    }

    public function findOrFail($idUser)
    {

        $idUser = HelperString::clearSymbolsString(filter_var($idUser['url'], FILTER_SANITIZE_NUMBER_INT));

        return $this->user->findDetail('id', $idUser);

    }

}