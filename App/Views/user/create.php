<div class="container">
    <div class="starter-template">

        <?php if (!empty($params['params'])) {
            echo '<div class="alert  mt-2 alert-danger">';
            foreach ($params['params'][1] as $errors) {
                echo '<p class="p-0 m-0">' . trim($errors) . '</p>';
            }
            echo '</div>';
        } ?>

        <!--        --><?php //\App\Helpers\Util::dumpdie($params['cidades']); ?>

        <div class=" my-3 ">
            <div class="p-2">
                <h2>Cadastro de usuario</h2>
            </div>
            <div class="card-body p-2">
                <form action="/user/save" method="post" enctype="multipart/form-data">
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="nome">Nome Completo</label>
                            <input type="text" class="form-control" id="nome"
                                <?php if (!empty($params['params'][0]['nome'])) {
                                    echo "value='" . trim($params['params'][0]['nome']) . "'";
                                } ?>
                                   name="nome"
                                   required>
                        </div>
                        <div class="col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email"
                                <?php if (!empty($params['params'][0]['email'])) {
                                    echo "value='" . trim($params['params'][0]['email']) . "'";
                                } ?>
                                   name="email"
                                   required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="cpf">CPF</label>
                            <input type="text" class="form-control"
                                <?php if (!empty($params['params'][0]['cpf'])) {
                                    echo "value='" . trim($params['params'][0]['cpf']) . "'";
                                } ?>
                                   id="cpf" name="cpf" required>
                        </div>
                        <div class="col-md-6">
                            <label for="telefone">Telefone</label>
                            <input type="text" class="form-control"
                                <?php if (!empty($params['params'][0]['telefone'])) {
                                    echo "value='" . trim($params['params'][0]['telefone']) . "'";
                                } ?>
                                   id="telefone" name="telefone" required>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="cargo">Cargo</label>
                            <input type="text" class="form-control" id="cargo"
                                <?php if (!empty($params['params'][0]['cargo'])) {
                                    echo "value='" . trim($params['params'][0]['cargo']) . "'";
                                } ?>
                                   name="cargo" required>
                        </div>
                        <div class="col-md-6">
                            <label for="data_nascimento">Data de nascimento</label>
                            <input type="date" class="form-control" id="data_nascimento"
                                <?php if (!empty($params['params'][0]['data_nascimento'])) {
                                    echo "value='" . trim($params['params'][0]['data_nascimento']) . "'";
                                } ?>
                                   name="data_nascimento" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="cidade">Cidade</label>
                            <select type="text" class="form-control" id="cidade" name="cidade" required>
                                <option value="">Selecione sua cidade</option>
                                <?php foreach ($params['cidades'] as $cidade) { ?>
                                    <option value="<?php echo $cidade['id'] ?>"><?php echo $cidade['nome'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="endereco">Endereço</label>
                            <input type="text" class="form-control" id="endereco"
                                <?php if (!empty($params['params'][0]['endereco'])) {
                                    echo "value='" . trim($params['params'][0]['endereco']) . "'";
                                } ?>
                                   name="endereco" required>
                        </div>
                    </div>

                    <div class="form-group d-flex flex-column">
                        <label for="">Informe o comprovante de residencia</label>
                        <input type="file" class="hidden" id="arquivo" name="arquivo">
                    </div>


                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>


        </div>
    </div>
