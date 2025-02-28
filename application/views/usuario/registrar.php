<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<body>
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="row">
            <div class="col-sm-12 p-4">
                <div class="card">
                    <div class="card-body">
                    <h2 class="mb-4">Cadastro</h2>
                    <?php if ($this->session->flashdata('erro')): ?>
                        <div class="alert alert-danger"><?= $this->session->flashdata('erro') ?></div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('sucesso')): ?>
                        <div class="alert alert-success"><?= $this->session->flashdata('sucesso') ?></div>
                    <?php endif; ?>
                <form action="<?=base_url('registrarnow')?>" method="POST">
                    <div class="mb-2">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" placeholder="000.000.000-00" required>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-2">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="sobrenome" class="form-label">Sobrenome</label>
                            <input type="text" class="form-control" id="sobrenome" name="sobrenome" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="(00) 00000-0000" required>
                    </div>
                    <div class="mb-2">
                        <label for="estado_civil" class="form-label">Estado Civil</label>
                        <select class="form-select" id="estado_civil" name="estado_civil" required>
                            <option value="Solteiro">Solteiro</option>
                            <option value="Casado">Casado</option>
                            <option value="Divorciado">Divorciado</option>
                            <option value="Viúvo">Viúvo</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>
                    <h4 class="mt-4">Endereços</h4>
                    <div id="enderecosContainer">
                        <div class="card p-3 mb-3">
                            <div class="mb-3">
                                <label class="form-label">CEP</label>
                                <input type="text" class="form-control cep" name="cep[]" placeholder="00000-000" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Endereço</label>
                                <input type="text" class="form-control" name="endereco[]" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Número</label>
                                <input type="text" class="form-control" name="numero[]" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Complemento</label>
                                <input type="text" class="form-control" name="complemento[]">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Observações</label>
                                <textarea class="form-control" name="observacoes[]"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-success" id="addEndereco">Adicionar Novo Endereço</button>
                    

                    <button type="submit" class="btn btn-primary m-4">Cadastrar</button>
                </form>
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#cpf').mask('000.000.000-00');

            $('#telefone').mask('(00) 00000-0000');
            $('.cep').mask('00000-000');
            

            $('#addEndereco').click(function() {
                let enderecoHtml = `
                    <div class="card p-3 mb-3">
                        <div class="mb-3">
                            <label class="form-label">CEP</label>
                            <input type="text" class="form-control cep" name="cep[]" placeholder="00000-000" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Endereço</label>
                            <input type="text" class="form-control" name="endereco[]" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Número</label>
                            <input type="text" class="form-control" name="numero[]" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Complemento</label>
                            <input type="text" class="form-control" name="complemento[]">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Observações</label>
                            <textarea class="form-control" name="observacoes[]"></textarea>
                        </div>
                        <button type="button" class="btn btn-danger removeEndereco">Remover</button>
                    </div>
                `;
                $('#enderecosContainer').append(enderecoHtml);
                $('.cep').mask('00000-000');
            });

            $(document).on('click', '.removeEndereco', function() {
                $(this).closest('.card').remove();
                $('.cep').mask('00000-000');
            });

        });
    </script>
</body>
</html>
