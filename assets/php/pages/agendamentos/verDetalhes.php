<?php
include "../../../database/conexao.php";

$idAgendamento = $_GET["idAgendamento"];

$sqlAgendamento = 
"SELECT `idAgendamento`, 
DATE_FORMAT(`dataAgendamento`, '%d/%m/%Y') AS `dataAgendamento`,
DATE_FORMAT(`dataAgendamento`, '%H:%m') AS `horarioAgendamento`,
`tipoAgendamento`, 
`conteudoAgendamento`, 
`envolvidosAgendamento`, 
`statusAgendamento` 
FROM `agendamento` WHERE `idAgendamento` = {$idAgendamento} 
ORDER BY `dataAgendamento` DESC;";

$sqlAnexo = 
"SELECT `idAnexo`, 
`idAgendamento`, 
`nomeAnexo`, 
`textoAnexo` 
FROM `anexosagendamento` 
WHERE `idAgendamento` = {$idAgendamento}";

// Consulta e atribuição dos campos da tabela "agendamento"
$resultadoConsultaAgendamento = mysqli_query($conn, $sqlAgendamento) or die("Erro ao executar a consulta!" . mysqli_error($conn));
$dadosEmColunasAgendamento = mysqli_fetch_assoc($resultadoConsultaAgendamento);
// Consulta e atribuição dos campos da tabela "anexo"
$resultadoConsultaAnexo = mysqli_query($conn, $sqlAnexo) or die("Erro ao executar a consulta!" . mysqli_error($conn));
$iconeStatus = null;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver detalhes do agendamento de ID <?= $dadosEmColunasAgendamento["idAgendamento"]; ?></title>
    <link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">
    <!-- CSS Génerico e Específico de cada página (se tiver) -->
    <link rel="stylesheet" href="../../../css/global.css">
    <link rel="stylesheet" href="../../../css/pages/verDetalhes.css">
</head>

<body class="bg-dark">

    <header>
        <!-- Barra topo da tela -->
        <nav class="fixed-top navbar navbar-expand-lg" data-bs-theme="dark" style="background-color: green;">
            <div class="container-fluid">
                <a class="navbar-brand" href="home.php">
                    <img src="./../../../images/global/logo.png" width="30">
                    DTI
                </a>
                <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarConteudo" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarConteudo">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="../login/login.php">Login</a>
                        </li>
                        <li class="nav-item">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">Agendamentos</a>
                            <ul class="dropdown-menu dropdown-menu-dark w-25">
                                <li><a class="dropdown-item" href="listarAgendamentos.php"><i
                                            class="bi bi-card-list"></i>
                                        Listar</a></li>
                                <li><a class="dropdown-item" href="agendar.php"><i
                                            class="bi bi-calendar2-plus-fill"></i>
                                        Agendar</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="estoque.php">Estoque</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <!-- Identificador do agendamento -->
            <div class="row">
                <h1
                    class="col-auto ms-1 ms-md-0 p-2 ps-1 fs-5 rounded-end-5 rounded-3 border shadow-sm text-light text-center">
                    <?= $dadosEmColunasAgendamento["idAgendamento"] ?>
                </h1>
            </div>
            <div class="row">
                <!-- Conteúdo do agendamento -->
                <div class="col-12 col-md-8 ms-1 me-2 ms-md-0 me-md-0 rounded-3 border border-light-subtle shadow"
                    style="height: 550px;">
                    <i class="bi bi-quote text-light fs-3 ms-1 opacity-50 pb-0"></i>
                    <p class="ms-3 me-2 fs-5 pe-3 text-light overflow-scroll overflow-x-hidden justificar-texto scrollPersonalizado"
                        style="height: 420px;">
                        <?= $dadosEmColunasAgendamento["conteudoAgendamento"] ?>
                    </p>
                    <div class="" style="transform: rotate(180deg); margin-top: 30px;">
                        <i class="bi bi-quote text-light ms-2 fs-3 opacity-50"></i>
                    </div>
                </div>

                <!-- Status do Agendamento -->
                <div class="col m-1 m-md-0 ms-md-2 border shadow rounded-3">
                    <div class="row flex-column">
                        <div class="col align-content-center" style="padding-top: 3%; padding-bottom: 23%;">
                            <p class="text-white text-center mb-0">Tipo:</p>
                            <h3 class="text-center" style="color: rgba(255, 255, 255, 0.555);">
                                <strong><?= $dadosEmColunasAgendamento["tipoAgendamento"]; ?></strong>
                            </h3>
                        </div>
                        <div class="col py-5">
                            <p class="text-center mb-0 text-light" style="font-size: 80%;">Tarefa marcada para o dia</p>
                            <h3 class="text-center mb-0 fs-1 text-light"><time
                                    datetime="<?= $dadosEmColunasAgendamento["dataAgendamento"]; ?>"><?= $dadosEmColunasAgendamento["dataAgendamento"]; ?></time><i
                                    class="bi bi-calendar-event ms-1"></i>
                            </h3>
                            <h3 class="text-center mt-0 fs-4 text-light" style="font-family: 'Oxanium', sans-serif;">as
                                <time
                                    datetime="<?= $dadosEmColunasAgendamento['horarioAgendamento']; ?>"><?= $dadosEmColunasAgendamento['horarioAgendamento']; ?></time><i
                                    class="bi bi-stopwatch ms-1"></i>
                            </h3>
                            <h4 class="text-center mt-4 fs-6 text-light">Status:</h4>
                            <p class="text-center">
                                <?php //Trecho para alterar o ícone do status e exibir-lo
                                if ($dadosEmColunasAgendamento["statusAgendamento"] == "pendente") {
                                    $iconeStatus = '<i class="bi bi-exclamation-circle-fill text-warning"> Pendente</i>';
                                } elseif ($dadosEmColunasAgendamento["statusAgendamento"] == "realizado") {
                                    $iconeStatus = '<i class="bi bi-check-circle-fill text-success"> Realizado</i>';
                                };

                                echo $iconeStatus;
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Envolvidos no agendamento -->
            <div class="row mt-3">
                <div class="col p-0 rounded-1 shadow" style="height: 60px; max-width: 50px;">
                    <span class="d-flex h-100 justify-content-center rounded-1 align-items-center bg-black"
                        style="width: 50px;"><i class="bi bi-people text-light"></i></span>
                </div>
                <div class="col ms-2 p-0 rounded-1 border shadow">
                    <div class="form-floating h-100">
                        <p class="bg-dark text-white ms-2 fs-6 fw-bold">Envolvidos na Tarefa:</p>
                        <label class="text-light mt-2 fs-6">
                            <?= $dadosEmColunasAgendamento["envolvidosAgendamento"]; ?>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Seção dos anexos, inclui a foto e a descrição -->
    <footer class="bg-black shadow-lg" style="margin-top: 80px;">
        <?php
        if ($resultadoConsultaAnexo->num_rows === 0) { //Condição que se não possuir registro no banco dos anexos ele cria uma parte informando por texto que não possui anexos neste agendamento, mas se possuir ele faz toda a criação das colunas com anexo de imagem e texto.
        ?>
        <div class="position-absolute w-100" style="position: relative; z-index: 2;">
            <p class="text-center text-white fs-4 fw-bold bg-secondary rounded-bottom-4 fs-2">Não há anexos neste
                agendamento</p>
        </div>
        <div style="filter: blur(3px); z-index: 1;">
            <?php
        };
            ?>
            <div class="container mt-5 pt-5 pb-4">
                <div class="row mb-5 justify-content-center justify-content-md-start" style="gap: 2rem 10rem;">
                    <?php
                    if ($resultadoConsultaAnexo->num_rows === 0) { //Condição que se não possuir registro no banco dos anexos ele cria placeholders para ilustrar
                        for ($i = 0; $i < 3; $i++) { //For para mostrar três colunas somente para ilustrar
                    ?>
                    <div class="col-3 bg-dark m-0 mt-2 p-0 border rounded-3 shadow-lg colAnexoAltura">
                        <svg class="bd-placeholder-img card-img-top" width="100%" height="180"
                            xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder"
                            preserveAspectRatio="xMidYMid slice" focusable="false">
                            <title>Placeholder</title>
                            <rect width="100%" height="100%" fill="#868e96"></rect>
                        </svg>
                        <p class="placeholder-glow">
                            <span class="bg-light placeholder col-7"></span>
                            <span class="bg-light placeholder col-4"></span>
                            <span class="bg-light placeholder col-4"></span>
                            <span class="bg-light placeholder col-7"></span>
                            <span class="bg-light placeholder col-8"></span>
                            <span class="bg-light placeholder col-2"></span>
                        </p>
                    </div>
                    <?php
                        };
                    } else {
                        while ($linhaTabela = mysqli_fetch_assoc($resultadoConsultaAnexo)) {
                            $inputAnexoImagem = null;
                            $pAnexoTexto = null;
                            if ($linhaTabela['textoAnexo'] === "") {
                                $divEnxaixeAnexoImagem = '<div class="w-100 h-100 overflow-hidden">';
                                $inputAnexoImagem = '<input class="w-100 h-100 rounded-top-3 rounded-bottom-3 overflow-hidden thumbAnexo" type="image" onmouseover="expandirImagemFundo(this)" onmouseleave="retrairImagemFundo(this)" data-bs-toggle="modal" data-bs-target="#' . $linhaTabela['nomeAnexo'] . '" src="../../../database/storage/arquivosAnexos/' . $linhaTabela['nomeAnexo'] . '" alt="">';
                            } else {
                                $divEnxaixeAnexoImagem = '<div class="w-100 h-50 border-bottom border-2 overflow-hidden">';
                                $inputAnexoImagem = '<input class="w-100 h-100 rounded-top-3 overflow-hidden thumbAnexo" type="image" onmouseover="expandirImagemFundo(this)" onmouseleave="retrairImagemFundo(this)" data-bs-toggle="modal" data-bs-target="#' . $linhaTabela['nomeAnexo'] . '" src="../../../database/storage/arquivosAnexos/' . $linhaTabela['nomeAnexo'] . '" alt="">';
                                $pAnexoTexto = '<p class="ms-1 text-white overflow-y-scroll justificar-texto scrollPersonalizado" style="max-height: 47%;">' . $linhaTabela['textoAnexo'] . '</p>';
                            };

                            echo '<div class="col-10 col-md-3 bg-dark p-0 border rounded-3 shadow-lg colAnexoAltura" style="max-width: 60%;">';
                            echo $divEnxaixeAnexoImagem;
                            echo $inputAnexoImagem;
                            echo '</div>';
                            echo $pAnexoTexto;
                            echo '</div>';
                        }
                    };
                    ?>
                </div>
    </footer>

    <!-- Código PHP para criação dos modal's das fotos dos anexos para cada anexo. -->
    <?php
    mysqli_data_seek($resultadoConsultaAnexo, 0); //Reseta o ponteiro
    $contIdModal = 0;
    while ($linhaTabela = mysqli_fetch_assoc($resultadoConsultaAnexo)) {
        $contIdModal++;
    ?>
    <!-- Modal do anexo -->
    <div class="modal fade" id="<?= $linhaTabela['nomeAnexo']; ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered justify-content-center">
            <img class="" style="object-fit: contain; height: 90vh; width: 90vw;"
                src="../../../database/storage/arquivosAnexos/<?= $linhaTabela['nomeAnexo']; ?>" alt="">
        </div>
    </div>
    <?php
    };
    ?>

    <!-- Scripts framework e específicos de cada página (se tiver) -->
    <!-- Bootstrap Framework -->
    <script src="../../../js/frameworks/bootstrap.bundle.min.js"></script>
    <!-- Script -->
    <script src="../../../js/pages/verDetalhes.js"></script>
</body>

</html>