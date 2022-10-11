<?php

use App\Models\Usuario as Usuario;

?>

<div class="container">
    <div class="row">
        <br>
        <div class="col-md-12 my-5">
            <h3>Detalhes do usuario</h3>
        </div>
        <div class="col-md-12">

            <div class="card p-3">
                <div class="d-flex justify-content-between">
                    <div class="dados-pessoais">
                        <p>NOME : <?php echo $params['params']['nome']; ?> </p>
                        <p>CPF : <?php echo Usuario::getAttributeCpf($params['params']['cpf']); ?> </p>
                        <p>TELEFONE : <?php echo Usuario::getAttributeTelefone($params['params']['telefone']); ?> </p>
                        <p>EMAIL : <?php echo $params['params']['email']; ?> </p>
                        <p>DATA NASCIMENTO
                            : <?php echo date('d-m-Y', strtotime($params['params']['data_nascimento'])) ?> </p>
                        <p>Cidade : <?php echo $params['params']['cidade'] ?> </p>
                    </div>
                    <div class="comprovante">
                        <a href="../../../public/images/<?php echo $params['params']['file']; ?>" class="btn btn-info">Baixar
                            Comprovante</a>
                        <a href="/comprovante/index/<?php echo $params['params']['id']; ?>" class="btn btn-info">comprovante
                            de cadastro</a>
                    </div>
                </div>
            </div>

        </div>
    </div>