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
    <link rel="stylesheet" href="./CSS/bootstrap-icons.css">
    <!-- CSS Génerico e Específico de cada página (se tiver) -->
    <link rel="stylesheet" href="./css/padrao.css">
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
    
        <?php
        $sql = "SELECT id,tipoEquipamento,numeroPatrimonio,numeroSerie,quantidade FROM dbestoque";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        ?>
        <div class="container mt-5">

            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-responsive-sm table-bordered">
                            <thead id=thead-users>
                                <tr class=text-center>
                                    <th>ID</th>
                                    <th>Equipamento</th>
                                    <th>Patrimonio</th>
                                    <th>Número de Serie</th>
                                    <th>Quantidade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {

                                    //print_r($row); 
                                    echo "<tr style='text-align: center'>";
                                    echo "<td>" . $row["id"] . "</td>";
                                    echo "<td>" . $row["tipoEquipamento"] . "</td>";
                                    echo "<td>" . $row["numeroPatrimonio"] . "</td>";
                                    echo "<td>" . $row["numeroSerie"] . "</td>";
                                    echo "<td>" . $row["quantidade"] . "</td>";
                                    echo "</tr>";
                                }                            
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script src="./js/bootstrap.bundle.min.js"></script>
</body>
</html>