<?php

namespace App\Helpers;

use App\Models\Usuario;

class UpdateDoc
{

    const EXTENSOES = ['jpg', 'pdf', 'png'];

    public static function updateDoc($doc, $userId = '', $cpf): array
    {
        $extensaoDoc = HelperString::extersaoDoc($doc['name']);

        $newNameFile = $cpf . '.' . $extensaoDoc;

        $params = ['column' => 'file', 'value' => $newNameFile];

        $response = (new Usuario())->updateFile($params, $userId);

        if ($response) {
            $directory = 'public/images/';
            move_uploaded_file($doc['tmp_name'], $directory . $newNameFile);
        }

        if (!$response) {
            Usuario::delete('id', $userId);
            return ['error' => 'tivemos problema para inserir seu arquivo, tente cadastrar novamente'];
        }

        return ['success' => 'registro salvo com sucesso'];

    }


}