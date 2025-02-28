<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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
        <h2>Dashboard - Usuários do Sistema</h2>
        <?php if ($this->session->flashdata('erro')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('erro') ?></div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('sucesso')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('sucesso') ?></div>
        <?php endif; ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>CPF</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= $usuario->id; ?></td>
                        <td><?= $usuario->nome; ?></td>
                        <td><?= $usuario->email; ?></td>
                        <td><?= $usuario->cpf; ?></td>
                        <td>
                            <?php
                            if($usuario->status == 1){?>
                                <a href="<?= site_url('usuario/editar/'.$usuario->id); ?>" class="btn btn-warning btn-sm">Editar</a>
                            <?php }
                            ?>
                            <a href="<?= site_url('usuario/ver/'.$usuario->id); ?>" class="btn btn-info btn-sm">Ver</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
