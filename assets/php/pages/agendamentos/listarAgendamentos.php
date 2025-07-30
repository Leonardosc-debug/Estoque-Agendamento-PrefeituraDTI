<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Agendamentos</title>
    <link rel="shortcut icon" href="./../../../images/global/logo.png" type="image/x-icon">
    <!-- CSS Génerico e Específico de cada página (se tiver) -->
    <link rel="stylesheet" href="../../../css/global.css">
    <link rel="stylesheet" href="../../../css/pages/listarAgendamentos.css">
</head>

<body>
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
                            <a class="nav-link" href="../estoque/estoque.php">Estoque</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Campo de pesquisa e filtro-->
    <main class="d-flex justify-content-center">
        <div class="card" style="min-width: 40%;">
            <div class="card-body">
                <form class="container">
                    <div class="row">
                        <div class="col form-floating">
                            <input class="form-control shadow-sm" type="search" id="inputConteudo" placeholder="">
                            <label for="inputConteudo" style="margin-left: 9px;">Pesquisar por conteúdo ou ID</label>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6 col-sm-4">
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-black"><i class="bi bi-journal text-white"
                                        id="iconeTipo"></i></span>
                                <select class="form-select" onchange="alteradorIconeTipo()" id="inputTipo">
                                    <option value="" selected>Filtrar o tipo...</option>
                                    <option value="Manutenção">Manutenção</option>
                                    <option value="Organização">Organização</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4">
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-black"><i class="bi bi-tag text-white"
                                        id="iconeStatus"></i></span>
                                <select class="form-select" onchange="alteradorIconeStatus()" id="inputStatus">
                                    <option value="" selected>Filtrar o status...</option>
                                    <option class="text-warning border-1" value="pendente">Pendente</option>
                                    <option class="text-success border-1" value="realizado">Realizado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6 col-sm-4">
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-black" for="inputData"><i
                                        class="bi bi-calendar-range text-white"></i></span>
                                <input class="form-control" type="date" id="inputData"
                                    title="Define o período inicial do filtro ou o dia exato"
                                    onchange="liberarDateAte(this)">
                            </div>
                        </div>
                        <div class="col-6 col-sm-4">
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-black" for="inputData"><i
                                        class="bi bi-calendar-range-fill text-white"></i></span>
                                <input class="form-control" type="date" id="inputDataAte"
                                    title="Define o período final do filtro" disabled>
                            </div>
                        </div>
                    </div>
                    <p class="opacity-75 mt-1 mb-0 fst-italic justificar-texto" style="font-size: 9px; width: 66%;">
                        *O primeiro botão de seleção de data define o dia exato do agendamento ou
                        marca o início do período de agendamentos.
                    </p>
                    <div class="row justify-content-end gap-2">
                        <a href="./agendar.php" class="col-4 col-lg-2 btn btn-warning" style="width: 40px;">
                            <i class="bi bi-calendar2-plus-fill"></i>
                        </a>
                        <button class="col-4 col-lg-2 btn btn-danger" type="button" style="width: 40px;"
                            title="Limpa os filtros selecionados" onclick="limparFiltros()">
                            <i class="bi bi-funnel-fill"></i>
                        </button>
                        <button class="col-4 col-lg-2 btn btn-primary" type="submit" style="width: 40px;">
                            <i class="bi bi-search text-center w-100"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Tabela com agendamentos-->
    <section class="mt-3 mx-auto comprimentoTabelaResponsivo">
        <div class="card">
            <div class="card-body overflow-auto" id="divTabela">
                <table id="tabela" class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Status</th>
                            <th scope="col">Data</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Conteúdo</th>
                            <th scope="col">Envolvidos</th>
                            <th scope="col">Item do Estoque</th>
                            <th scope="col"></th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Scripts framework e específicos de cada página (se tiver) -->
    <!-- Jquery Lib -->
    <script src="../../../js/libs/jquery.min.js"></script>
    <!-- Bootstrap Framework -->
    <script src="../../../js/frameworks/bootstrap.bundle.min.js"></script>
    <!-- Script  -->
    <script src="../../../js/pages/listarAgendamentos.js"></script>

</html>
</body>

</html>