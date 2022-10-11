<?php

use App\Models\Usuario;

?>

<div class="container">
    <div class="starter-template">
        <div class="card my-3 ">
            <div class="d-flex justify-content-between align-items-center p-3">
                <h3>Lista de registros</h3>
                <a href="/user/create" class="btn btn-success btn-sm">Adicionar</a>
            </div>

            <?php
            if (!count($params['user'])) {
                ?>
                <div class="alert alert-info mx-3" role="alert">Nenhum Usuario encontrado</div>
                <?php
            } else {
                ?>
                <table class="table table-striped ">
                    <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Cpf</th>
                        <th scope="col" class="responsiv-display-none">telefone</th>
                        <th scope="col" class="responsiv-display-none">Email</th>
                        <th scope="col">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($params['user'] as $usuario) { ?>
                        <tr>
                            <th scope="row"><?php echo $usuario['id']; ?></th>
                            <td><?php echo $usuario['nome']; ?></td>
                            <td><?php echo Usuario::getAttributeCpf($usuario['cpf']); ?></td>
                            <td class="responsiv-display-none"><?php echo Usuario::getAttributeTelefone($usuario['telefone']) ?></td>
                            <td class="responsiv-display-none"><?php echo $usuario['email']; ?></td>
                            <td><a href="/user/detail/<?php echo $usuario['id']; ?>"
                                   class="btn btn-info btn-sm">Saiba mais</a></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                <?php
            }
            ?>
        </div>
    </div>


