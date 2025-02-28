<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Usuário</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url('dashboard') ?>">Sistema de Usuários</a>
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
        <h2>Informações do Usuário</h2>
        <table class="table table-bordered">
            <tr><th>Nome:</th><td><?= $usuario['nome'] ?></td></tr>
            <tr><th>Email:</th><td><?= $usuario['email'] ?></td></tr>
            <tr><th>CPF:</th><td><?= $usuario['cpf'] ?></td></tr>
            <tr><th>Telefone:</th><td><?= $usuario['telefone'] ?></td></tr>
            <tr><th>Estado Civil:</th><td><?= $usuario['estado_civil'] ?></td></tr>
        </table>

        <h3>Endereços</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>CEP</th>
                    <th>Endereço</th>
                    <th>Número</th>
                    <th>Complemento</th>
                    <th>Observações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($usuario['enderecos'])) : ?>
                    <?php foreach ($usuario['enderecos'] as $endereco) : ?>
                        <tr>
                            <td><?= $endereco['cep']?></td>
                            <td><?= $endereco['endereco'] ?></td>
                            <td><?= $endereco['numero'] ?></td>
                            <td><?= $endereco['complemento'] ?></td>
                            <td><?= $endereco['observacoes'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center">Nenhum endereço cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="<?= base_url('usuario') ?>" class="btn btn-primary">Voltar</a>
        <a href="<?= base_url('ativar/' . $usuario['id']) ?>" class="btn btn-success">Ativar</a>

    </div>
</body>
</html>
