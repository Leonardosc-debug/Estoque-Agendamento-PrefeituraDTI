<?php
require "../../../database/conexao.php";

$idAgendamento = $_GET["idAgendamento"];
$sqlAgendamento =
"SELECT `idAgendamento`,
`dataAgendamento`,
`tipoAgendamento`, 
`conteudoAgendamento`, 
`envolvidosAgendamento`, 
`statusAgendamento` 
FROM `agendamento` WHERE `idAgendamento` = {$idAgendamento} ORDER BY `dataAgendamento` DESC";
$sqlAnexo =
"SELECT `idAnexo`, 
`idAgendamento`, 
`nomeAnexo`, 
`textoAnexo` 
FROM `anexosagendamento` 
WHERE `idAgendamento` = {$idAgendamento}";

// Consulta e atribuição dos campos da tabela "agendamento"
$resultadoConsultaAgendamento = mysqli_query($conn, $sqlAgendamento) or die("Erro ao executar a consulta!");
$dadosEmColunasAgendamento = mysqli_fetch_assoc($resultadoConsultaAgendamento);
// Consulta e atribuição dos campos da tabela "anexo"
$resultadoConsultaAnexo = mysqli_query($conn, $sqlAnexo) or die("Erro ao executar a consulta!");

$conn -> close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">
    <!-- CSS Génerico e Específico de cada página (se tiver) -->
    <link rel="stylesheet" href="../../../css/global.css">
    <link rel="stylesheet" href="../../../css/pages/editarAgendamento.css">
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
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">Agendamentos</a>
                            <ul class="dropdown-menu dropdown-menu-dark w-25">
                                <li><a class="dropdown-item" href="../agendamentos/listarAgendamentos.php"><i
                                            class="bi bi-card-list"></i>
                                        Listar</a></li>
                                <li><a class="dropdown-item" href="../agendamentos/agendar.php"><i
                                            class="bi bi-calendar2-plus-fill"></i>
                                        Agendar</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../estoque/estoque.php">Estoque</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- Formulário para agendamento -->
        <div class="container">
            <h1 class="text-white text-center" style="-webkit-text-fill-color: transparent; -webkit-text-stroke: 1px;">
                EDITAR</h1>
            <form class="row justify-content-center">
                <div class="col-11 col-md p-3 bg-secondary-subtle border-0 rounded overflow-auto scrollPersonalizado"
                    id="colunaDireita" style="max-height: 700px;">
                    <div class="mb-2">
                        <label for="dataAgendamento">Editar para a data:</label>
                        <input class="form-control" style="width: 185px;" type="datetime-local" id="dataAgendamento"
                            name="dataAgendamento" value="<?= $dadosEmColunasAgendamento['dataAgendamento']; ?>"
                            required>
                    </div>
                    <label class="form-label">Tipo do agendamento:</label>
                    <div class="mb-2 form-check" data-tiposalvo="<?= $dadosEmColunasAgendamento['tipoAgendamento']; ?>">
                        <input class="form-check-input" type="radio" name="tipoAgendamento" id="tipoAgendamentoManut"
                            value="Manutenção" checked>
                        <label class="form-check-label" for="tipoAgendamentoManut"> Manutenção</label>
                    </div>
                    <div class="mb-2 form-check">
                        <input class="form-check-input" type="radio" name="tipoAgendamento" id="tipoAgendamentoOrga"
                            value="Organização">
                        <label class="form-check-label" for="tipoAgendamentoOrga"> Organização</label>
                    </div>
                    <div class="mb-2">
                        <label for="conteudoAgendamento">Contéudo do agendamento:</label>
                        <textarea class="form-control" placeholder="" id="conteudoAgendamento"
                            name="conteudoAgendamento" rows="5"
                            required><?= $dadosEmColunasAgendamento['conteudoAgendamento']; ?></textarea>
                    </div>
                    <div class="mb-3 input-group">
                        <span class="input-group-text bg-black"><i class="bi bi-people text-light"></i></span>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="envolvidosAgendamento"
                                name="envolvidosAgendamento" placeholder=""
                                value="<?= $dadosEmColunasAgendamento['envolvidosAgendamento']; ?>">
                            <label for="floatingInputGroup1">Envolvidos na tarefa</label>
                        </div>
                    </div>
                    <div class="input-group" data-statussalvo="<?= $dadosEmColunasAgendamento["statusAgendamento"]; ?>">
                        <span class="input-group-text bg-black h-75"><i id="iconeStatus"
                                class="bi bi-tag text-light"></i></span>
                        <select class="mb-3 form-select" id="selectStatus" name="statusAgendamento"
                            aria-label="Default select example" onchange="alteradorIconeStatus()"
                            name="statusAgendamento" required>
                            <option disabled value="">Status do agendamento</option>
                            <option value="pendente">Pendente</option>
                            <option value="realizado">Realizado</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

    </main>

    <!-- Seção dos anexos, inclui a foto e a descrição -->
    <footer class="mt-5 bg-black shadow-lg">
        <div class="container mt-5 pt-5 pb-4">
            <div class="row mb-5 justify-content-center justify-content-xxl-start" style="gap: 2rem 10rem;">
                <?php
                if ($resultadoConsultaAnexo->num_rows === 0) {
                ?>
                <div class="col">
                    <div class="card bg-dark w-25 colAnexoAltura">
                        <i class="align-content-center text-white text-center bi bi-plus-circle h-75"
                            style="font-size: 100px"></i>
                        <div class="card-body">
                            <h5 class="card-title text-white text-center">Adicionar anexo.</h5>
                        </div>
                        <button class="position-absolute h-100 w-100 bg-transparent border-0"></button>
                    </div>
                </div>
                <?php
                } else {
                    $i = 1;
                    while ($linhaTabela = mysqli_fetch_assoc($resultadoConsultaAnexo)) {
                    ?>
                <div class="col-10 col-md-4 col-xxl-3 bg-dark m-0 p-0 border rounded-3 shadow-lg colAnexoAltura">
                    <div class="position-relative h-50">
                        <div
                            class="w-100 h-100 border-bottom border-2 overflow-hidden position-absolute zoom-container">
                            <img class="w-100 h-100 rounded-top-3 thumbAnexo zoom-image"
                                id="imgFundo<?= $linhaTabela["idAnexo"] ?>"
                                src="../../../database/storage/arquivosAnexos/<?= $linhaTabela['nomeAnexo']; ?>" alt="">
                        </div>
                        <div class="d-flex opacity-0 w-100 align-content-center position-absolute divButoes">
                            <button class="bi bi-zoom-in text-white h-100 p-0 border-0 butoesImagem btnExpandir"
                                id="btnExpandir<?= $linhaTabela["idAnexo"] ?>" style="width: 50%; font-size: 190%;"
                                data-bs-toggle="modal" data-bs-target="#<?= $linhaTabela['nomeAnexo']; ?>"></button>
                            <button class="bi bi-upload text-white h-100 p-0 border-0 butoesImagem btnUpload"
                                id="btnUpload<?= $i; ?>" onclick="acionarInputArquivo(<?= $linhaTabela["idAnexo"] ?>)"
                                style="width: 50%; font-size: 190%;"></button>
                            <input class="visually-hidden uploadEscondido"
                                id="arquivoUpload<?= $linhaTabela["idAnexo"] ?>"
                                data-arquivo="<?= $linhaTabela['nomeAnexo']; ?>"
                                data-idanexo="<?= $linhaTabela["idAnexo"] ?>" type="file" accept=".jpg, .jpeg, .png">
                        </div>
                    </div>
                    <textarea
                        class="w-100 h-100 ms-1 bg-transparent border-0 text-white justificar-texto overflow-y-auto scrollPersonalizado textosAnexos"
                        data-idanexo="<?= $linhaTabela["idAnexo"] ?>"
                        style="max-height: 47%; resize: none;"> <?= $linhaTabela['textoAnexo']; ?></textarea>
                </div>
                <?php
                        $i++;
                    }
                };
                ?>
            </div>
    </footer>

    <!-- Status e botão de salvar flutuante -->
    <div class="fixed-bottom p-1 text-white">
        <p class="text-bg-success p-2 w-50 shadow rounded-2 fs-6 ms-2" id="statusSubmit" style="display: none;">EDIÇÃO
            REALIZADA COM
            SUCESSO!</p>
        <div class="position-absolute bottom-0 end-0 me-3">
            <button class="btn btn-lg rounded-circle btn-danger me-3 mb-3"
                style="--bs-btn-padding-y: .50rem; --bs-btn-padding-x: .9rem;" id="submitDelete"
                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Apagar agendamento."><i
                    class="bi bi-x-lg"></i></but>
                <button class="btn btn-lg rounded-circle btn-success mb-3" id="submit"
                    style="--bs-btn-padding-y: .50rem; --bs-btn-padding-x: .9rem;" type="submit"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Salvar"><i
                        class="bi bi-floppy-fill"></i></button>
        </div>
    </div>

    <?php
    // Código PHP para criação dos modal's das fotos dos anexos para cada anexo.
    mysqli_data_seek($resultadoConsultaAnexo, 0); //Reseta o ponteiro
    $contIdModal = 0;
    while ($linhaTabela = mysqli_fetch_assoc($resultadoConsultaAnexo)) {
    ?>
    <!-- Modal do anexo -->
    <div class="modal fade" id="<?= $linhaTabela['nomeAnexo']; ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered justify-content-center">
            <img class="" style="object-fit: contain; height: 90vh; width: 90vw;"
                id="imgModal<?= $linhaTabela['idAnexo']; ?>"
                src="../../../database/storage/arquivosAnexos/<?= $linhaTabela['nomeAnexo']; ?>" alt="">
        </div>
    </div>
    <?php
        $contIdModal++; // Incrementa o contador para cada modal
    };
    ?>

    <!-- Scripts framework e específicos de cada página (se tiver) -->
    <!-- Jquery Lib -->
    <script src="../../../js/libs/jquery.min.js"></script>
    <!-- Popper Lib -->
    <script src="../../../js/libs/popper.min.js"></script>
    <!-- Bootstrap Framework -->
    <script src="../../../js/frameworks/bootstrap.bundle.min.js"></script>
    <!-- Script  -->
    <script src="../../../js/pages/editarAgendamento.js"></script>
</body>

</html>