<?php

namespace App\Controllers;

use App\Services\Comprovante;
use App\Services\User;

class ComprovanteController
{

    public function index()
    {
        $usuario = (new User())->findOrFail($_GET);
        return (new Comprovante())->gerarComprovante($usuario);
    }
}