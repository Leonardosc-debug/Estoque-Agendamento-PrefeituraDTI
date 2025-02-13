<?php include("db\conexao.php"); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque</title>
    <link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/bootstrap-icons.css">
    <!-- CSS Génerico e Específico de cada página (se tiver) -->
    <link rel="stylesheet" href="./css/padrao.css">
    <link rel="stylesheet" href="./css/estoque.css">
</head>

<body>
    <div class="imagem-fundo"></div>
    <!-- Barra topo da tela -->
    <nav class="fixed-top navbar navbar-expand-lg" data-bs-theme="dark" style="background-color: green;">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">
                <img src="./IMG/logo.png" width="30">
                DTI
            </a>
            <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarConteudo" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarConteudo">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Agendamentos</a>
                        <ul class="dropdown-menu dropdown-menu-dark w-25">
                            <li><a class="dropdown-item" href="./agendamentos.php"><i
                                        class="bi bi-card-list"></i> Listar</a></li>
                            <li><a class="dropdown-item" href="./agendar.php"><i
                                        class="bi bi-calendar2-plus-fill"></i> Agendar</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="estoque.php">Estoque</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <header class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div>
            <div class="card border-primary" style="width: 22rem;">
                <div class="card-header text-center fw-bold fs-4">
                    Cadastro de Equipamento
                </div>

                <form class="card-body needs-validation" method="post" action="salvarEstoque.php">

                    <div class="mb-3">
                        <select id="tipoEquipamento" name="tipoEquipamento" class="form-select"
                            aria-label="Disabled select example" required>
                            <option value="" selected>Selecione...</option>
                            <?php  selectTipoEquipamento($conn);?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <div class="card-text text-left fw-style fs-5">
                            Patrimônio
                        </div>
                        <div class="form-floating mb-3">
                            <input id="numeroPatrimonio" name="numeroPatrimonio" class="form-control" type="text"
                                placeholder="Digite o Patrimônio">

                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="card-text text-left fw-style fs-5">
                            Número de Serie
                        </div>
                        <div class="form-floating mb-2">
                            <input id="numeroSerie" name="numeroSerie" class="form-control" type="text"
                                placeholder="Digite o número de série">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="card-text text-left fw-style fs-5">
                            Coloque a Quantidade.
                        </div>
                        <div class="form-floating">
                            <input id="quantidade" name="quantidade" class="form-control" type="number">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="mb-4 d-flex justify-content-end">
                            <button type="button" id="btnVer_Estoque" data-bs-toggle="modal"
                                data-bs-target="#caixaEsquecimento"><a href="verEstoque.php">Ver
                                    Estoque</a></button>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
        </div>
    </header>

    <script src="./JS/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php

function selectTipoEquipamento( $conn){                                
    $sql = "SELECT * FROM opcoes";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row["idOpcoes"]}'> {$row["nomeOpcoes"]}</option>";
    } 
}