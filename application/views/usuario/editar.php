<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>


</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Sistema de Usuários</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('usuario/logout'); ?>">Sair</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="col-sm-12">
        <div class="row justify-content-center">
            <div class="card col-sm-12 col-md-12">
                <div class="card-body">
                    <h2>Editar Usuário</h2>
                    <?php if ($this->session->flashdata('sucesso')): ?>
                        <div class="alert alert-success"><?= $this->session->flashdata('sucesso'); ?></div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('erro')): ?>
                        <div class="alert alert-danger"><?= $this->session->flashdata('erro'); ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('usuario/atualizar'); ?>" method="POST">
                        <input type="hidden" name="id" id="userId" value="<?= $usuario['id']; ?>">

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome:</label>
                            <input type="text" class="form-control" name="nome" value="<?= $usuario['nome']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="sobrenome" class="form-label">Sobrenome:</label>
                            <input type="text" class="form-control" name="sobrenome" value="<?= $usuario['sobrenome']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" name="email" value="<?= $usuario['email']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF:</label>
                            <input type="text" class="form-control" name="cpf" value="<?= $usuario['cpf']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone:</label>
                            <input type="text" class="form-control" name="telefone" value="<?= $usuario['telefone']; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="estado_civil" class="form-label">Estado Civil:</label>
                            <select class="form-control" name="estado_civil">
                                <option value="Solteiro" <?= ($usuario['estado_civil'] == 'Solteiro') ? 'selected' : ''; ?>>Solteiro</option>
                                <option value="Casado" <?= ($usuario['estado_civil'] == 'Casado') ? 'selected' : ''; ?>>Casado</option>
                                <option value="Divorciado" <?= ($usuario['estado_civil'] == 'Divorciado') ? 'selected' : ''; ?>>Divorciado</option>
                                <option value="Viúvo" <?= ($usuario['estado_civil'] == 'Viúvo') ? 'selected' : ''; ?>>Viúvo</option>
                            </select>
                        </div>

                        <h4>Endereços</h4>
                        <div id="enderecosContainer">
                            <?php foreach ($usuario['enderecos'] as $index => $endereco): ?>
                                <div class="endereco-item mb-3 border p-3">
                                    <input type="hidden" name="endereco_id[]" value="<?= $endereco['id']; ?>">

                                    <label>CEP:</label>
                                    <input type="text" class="form-control mb-2" name="cep[]" value="<?= $endereco['cep']; ?>">

                                    <label>Endereço:</label>
                                    <input type="text" class="form-control mb-2" name="endereco[]" value="<?= $endereco['endereco']; ?>">

                                    <label>Número:</label>
                                    <input type="text" class="form-control mb-2" name="numero[]" value="<?= $endereco['numero']; ?>">

                                    <label>Complemento:</label>
                                    <input type="text" class="form-control mb-2" name="complemento[]" value="<?= $endereco['complemento']; ?>">

                                    <label>Observações:</label>
                                    <input type="text" class="form-control mb-2" name="observacoes[]" value="<?= $endereco['observacoes']; ?>">

                                    <button type="button" class="btn btn-danger btn-sm removeEnderecoBanco"  data-id="<?= $endereco['id']; ?>">Remover</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-primary" id="addEndereco">Adicionar Endereço</button>
                        <button type="submit" class="btn btn-success">Salvar</button>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalSenha">Redefinir Senha</button>
                        <a href="<?= base_url('desativar/' . $usuario['id']) ?>" class="btn btn-danger" id="desativar">Desativar</a>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>

<!-- Modal para Redefinir Senha -->
<div class="modal fade" id="modalSenha" tabindex="-1" aria-labelledby="modalSenhaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSenhaLabel">Redefinir Senha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('usuario/redefinir'); ?>" method="POST">
                    <input type="hidden" name="id" value="<?= $usuario['id']; ?>">
                    
                    <div class="mb-3">
                        <label for="senha_antiga" class="form-label">Senha Antiga:</label>
                        <input type="password" class="form-control" name="senha_antiga" required>
                    </div>

                    <div class="mb-3">
                        <label for="nova_senha" class="form-label">Nova Senha:</label>
                        <input type="password" class="form-control" name="nova_senha" required>
                    </div>

                    <div class="mb-3">
                        <label for="confirmar_senha" class="form-label">Confirmar Nova Senha:</label>
                        <input type="password" class="form-control" name="confirmar_senha" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Alterar Senha</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
            $('#cpf').mask('000.000.000-00');

            $('#telefone').mask('(00) 00000-0000');
            $('.cep').mask('00000-000');
            

            $('#addEndereco').click(function() {
                let enderecoHtml = `
                    <div class="card p-3 mb-3">
                                    <input type="hidden" name="endereco_id[]" value="">

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
                        <button type="button" class="btn btn-danger removeEndereco" >Remover</button>
                    </div>
                `;
                $('#enderecosContainer').append(enderecoHtml);
                $('.cep').mask('00000-000');
            });

            $(document).on('click', '.removeEndereco', function() {
                $(this).closest('.card').remove();
                $('.cep').mask('00000-000');
            });

            $('.removeEnderecoBanco').on('click', function() {
                $.ajax({
                    url: '/usuario/excluirendereco',
                    type: 'POST',  
                    data: {
                        id_endereco: $(this).data('id'), 
                        id_usuario: $('#userId').val()
                    }
                });
            })

            

        });

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
