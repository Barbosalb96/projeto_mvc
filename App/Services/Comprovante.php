<?php

namespace App\Services;

use App\Helpers\Util;
use App\Models\Usuario as Usuario;
use Dompdf\Dompdf;
use Dompdf\Options;

class Comprovante
{
    public function gerarComprovante($params)
    {
        $dompdf = new Dompdf();

        $dompdf->loadHtml($this->model($params));

        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream();
    }

    public function model($params)
    {
        $model =
            '<h1 style="text-align: center">Comprovante de Inscrição</h1>' .
            '<h2>Ola ' . $params['nome'] . ' </h2>' .
            '<hr class="my-3"/>' .
            '<h3>Dados Pessoais</h3>' .
            '<h5>Telefone : ' . Usuario::getAttributeTelefone($params['telefone']) . ' </h5>' .
            '<h5>Cpf : ' . Usuario::getAttributeCpf($params['cpf']) . ' </h5>' .
            '<h5>Email : ' . $params['email'] . ' </h5>' .
            '<h5>Cidade : ' . $params['cidade'] . ' </h5>' .
            '<hr class="my-3"/>' .
            '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make
                 a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. 
                 It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, 
                and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>';
        return $model;
    }
}