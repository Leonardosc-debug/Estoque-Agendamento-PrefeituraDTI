<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar</title>
    <link rel="shortcut icon" href="./../../../images/global/logo.png" type="image/x-icon">
    <!-- CSS Génerico e Específico de cada página (se tiver) -->
    <link rel="stylesheet" href="../../../css/global.css">
    <link rel="stylesheet" href="../../../css/pages/agendar.css">
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

    <!-- Formulário para agendamento -->
    <main class="container align-content-center" style="height: calc(100vh - 80px);">
        <h1 class="text-white text-center" style="-webkit-text-fill-color: transparent; -webkit-text-stroke: 1px;">
            <i class="bi bi-calendar text-white"></i> AGENDAR
        </h1>
        <div class="row justify-content-center">
            <div class="col-11 col-md p-3 shadow bg-secondary-subtle border-0 rounded">
                <form class="row">
                    <div class="col-sm visually-hidden overflow-auto" id="colunaEsquerda" style="max-height: 477px;">
                        <div class="mb-3" id="grupoAnexos">
                            <div>
                                <h1 class="text-center opacity-75 mb-0" style="font-size: 15px;">O limite do tamanho dos
                                    anexos é de até 10MB.</h1>
                                <p class="text-center opacity-75 mt-0" style="font-size: 13px;">e só são aceitos as
                                    extensões: jpg, jpeg e png.</p>
                            </div>
                            <label>Anexo 1:</label>
                            <div class="ms-2 mb-2">
                                <input class="form-control" name="anexoArquivo" type="file"
                                    onchange="validarArquivo(this)" accept=".jpg, .jpeg, .png">
                                <textarea class="form-control mt-2" name="textoAnexo"
                                    placeholder="Insira o texto que acompanhará o anexo como descrição..." rows="2"
                                    disabled></textarea>
                            </div>
                            <label>Anexo 2:</label>
                            <div class="ms-2 mb-2">
                                <input class="form-control" name="anexoArquivo" type="file"
                                    onchange="validarArquivo(this)" accept=".jpg, .jpeg, .png" disabled>
                                <textarea class="form-control mt-2" name="textoAnexo"
                                    placeholder="Insira o texto que acompanhará o anexo como descrição..." rows="2"
                                    disabled></textarea>
                            </div>
                            <label>Anexo 3:</label>
                            <div class="ms-2 mb-2">
                                <input class="form-control" name="anexoArquivo" type="file"
                                    onchange="validarArquivo(this)" accept=".jpg, .jpeg, .png" disabled>
                                <textarea class="form-control mt-2" name="textoAnexo"
                                    placeholder="Insira o texto que acompanhará o anexo como descrição..." rows="2"
                                    disabled></textarea>
                            </div>
                            <label>Anexo 4:</label>
                            <div class="ms-2 mb-2">
                                <input class="form-control" name="anexoArquivo" type="file"
                                    onchange="validarArquivo(this)" accept=".jpg, .jpeg, .png" disabled>
                                <textarea class="form-control mt-2" name="textoAnexo"
                                    placeholder="Insira o texto que acompanhará o anexo como descrição..." rows="2"
                                    disabled></textarea>
                            </div>
                            <label>Anexo 5:</label>
                            <div class="ms-2 mb-2">
                                <input class="form-control" name="anexoArquivo" type="file"
                                    onchange="validarArquivo(this)" accept=".jpg, .jpeg, .png" disabled>
                                <textarea class="form-control mt-2" name="textoAnexo"
                                    placeholder="Insira o texto que acompanhará o anexo como descrição..." rows="2"
                                    disabled></textarea>
                            </div>
                            <label>Anexo 6:</label>
                            <div class="ms-2 mb-2">
                                <input class="form-control" name="anexoArquivo" type="file"
                                    onchange="validarArquivo(this)" accept=".jpg, .jpeg, .png" disabled>
                                <textarea class="form-control mt-2" name="textoAnexo"
                                    placeholder="Insira o texto que acompanhará o anexo como descrição..." rows="2"
                                    disabled></textarea>
                            </div>
                            <label>Anexo 7:</label>
                            <div class="ms-2 mb-2">
                                <input class="form-control" name="anexoArquivo" type="file"
                                    onchange="validarArquivo(this)" accept=".jpg, .jpeg, .png" disabled>
                                <textarea class="form-control mt-2" name="textoAnexo"
                                    placeholder="Insira o texto que acompanhará o anexo como descrição..." rows="2"
                                    disabled></textarea>
                            </div>
                            <label>Anexo 8:</label>
                            <div class="ms-2 mb-2">
                                <input class="form-control" name="anexoArquivo" type="file"
                                    onchange="validarArquivo(this)" accept=".jpg, .jpeg, .png" disabled>
                                <textarea class="form-control mt-2" name="textoAnexo"
                                    placeholder="Insira o texto que acompanhará o anexo como descrição..." rows="2"
                                    disabled></textarea>
                            </div>
                            <label>Anexo 9:</label>
                            <div class="ms-2 mb-2">
                                <input class="form-control" name="anexoArquivo" type="file"
                                    onchange="validarArquivo(this)" accept=".jpg, .jpeg, .png" disabled>
                                <textarea class="form-control mt-2" name="textoAnexo"
                                    placeholder="Insira o texto que acompanhará o anexo como descrição..." rows="2"
                                    disabled></textarea>
                            </div>
                            <label>Anexo 10:</label>
                            <div class="ms-2 mb-2">
                                <input class="form-control" name="anexoArquivo" type="file"
                                    onchange="validarArquivo(this)" accept=".jpg, .jpeg, .png" disabled>
                                <textarea class="form-control mt-2" name="textoAnexo"
                                    placeholder="Insira o texto que acompanhará o anexo como descrição..." rows="2"
                                    disabled></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col overflow-auto" id="colunaDireita" style="max-height: 477px;">
                        <div class="mb-2">
                            <label for="dataAgendamento">Agendar para a data:</label>
                            <input class="form-control" style="width: 185px;" type="datetime-local" id="dataAgendamento"
                                name="dataAgendamento" required>
                        </div>
                        <label class="form-label">Tipo do agendamento:</label>
                        <div class="mb-2 form-check">
                            <input class="form-check-input" type="radio" name="tipoAgendamento"
                                id="tipoAgendamentoManut" value="Manutenção" checked>
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
                                name="conteudoAgendamento" rows="4" required></textarea>
                        </div>
                        <div class="mb-3 input-group">
                            <span class="input-group-text bg-black"><i class="bi bi-people text-light"></i></span>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="envolvidosAgendamento"
                                    name="envolvidosAgendamento" placeholder="">
                                <label for="floatingInputGroup1">Envolvidos na tarefa</label>
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-black h-75"><i id="iconeStatus"
                                    class="bi bi-tag text-light"></i></span>
                            <select class="mb-3 form-select" id="selectStatus" name="statusAgendamento"
                                aria-label="Default select example" onchange="alteradorIconeStatus()"
                                name="statusAgendamento" required>
                                <option selected disabled value="">Status do agendamento</option>
                                <option value="pendente">Pendente</option>
                                <option value="realizado">Realizado</option>
                            </select>
                        </div>
                        <div class="d-flex mb-2 justify-content-between">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="flexSwitchMostrarAnexos" onchange="mostrarAbaAnexos()">
                                <span class="" for="flexSwitchMostrarAnexos">Inserir anexos?</span>
                            </div>
                            <div class="btn btn-success p-1 pe-2">
                                <button type="submit" class="bg-transparent text-white border-0">Agendar <i
                                        class="bi bi-calendar2-plus-fill"></i>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-2 rounded-1" id="statusSubmit"></div>
    </main>

    <!-- Scripts framework e específicos de cada página (se tiver) -->
    <!-- Jquery Lib -->
    <script src="../../../js/libs/jquery.min.js"></script>
    <!-- Bootstrap Framework -->
    <script src="../../../js/frameworks/bootstrap.bundle.min.js"></script>
    <!-- Script  -->
    <script src="../../../js/pages/agendar.js"></script>
</body>

</html>