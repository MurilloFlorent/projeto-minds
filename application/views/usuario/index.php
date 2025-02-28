<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minds</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="col-sm-12">
            <div class="row justify-content-center">
                <div class="card col-sm-12 col-md-4">
                    <div class="card-body">
                        <h4 class="card-title">Login</h4>
                        <?php if ($this->session->flashdata('erro')): ?>
                            <div class="alert alert-danger"><?= $this->session->flashdata('erro') ?></div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('sucesso')): ?>
                            <div class="alert alert-success"><?= $this->session->flashdata('sucesso') ?></div>
                        <?php endif; ?>
                        <form action="<?=base_url('loginnow')?>" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    aria-describedby="emailHelpId" placeholder="email@teste.com"/>
                                <small id="emailHelpId" class="form-text text-muted">email@teste.com</small>
                            </div>
                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    name="senha"
                                    id="senha"
                                    placeholder="Senha"
                                />
                            </div>
                            <div class="mb-3">
                                <a href="<?=base_url('registrar')?>">Registrar-se</a>
                            </div>
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
