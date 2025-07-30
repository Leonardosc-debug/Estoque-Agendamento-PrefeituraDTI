<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Estoque</title>
    <link rel="shortcut icon" href="./../../../images/global/logo.png" type="image/x-icon" />
    <!-- CSS Génerico e Específico de cada página (se tiver) -->
    <link rel="stylesheet" href="../../../css/global.css" />
    <link rel="stylesheet" href="../../../css/pages/estoque.css" />
</head>

<body class="bg-dark">
    <header>
        <!-- Barra topo da tela -->
        <nav class="fixed-top navbar navbar-expand-lg" data-bs-theme="dark" style="background-color: green">
            <div class="container-fluid">
                <a class="navbar-brand" href="home.php">
                    <img src="./../../../images/global/logo.png" width="30" />
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
                        <li class="nav-item"></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">Agendamentos</a>
                            <ul class="dropdown-menu dropdown-menu-dark w-25">
                                <li>
                                    <a class="dropdown-item" href="../agendamentos/listarAgendamentos.php"><i
                                            class="bi bi-card-list"></i> Listar</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="../agendamentos/agendar.php"><i
                                            class="bi bi-calendar2-plus-fill"></i> Agendar</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="../estoque/estoque.php">Estoque</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <div class="row align-items-center gap-3">
                <h1 class="col-2 text-white fw-bold fs-3">ESTOQUE</h1>
                <div class="col d-flex align-items-center">
                    <span class="bi-search text-white fs-5 me-3"></span>
                    <div class="form-floating w-100">
                        <input class="form-control bg-transparent text-white" type="search" id="pesquisaEstoque"
                            placeholder="">
                        <label class="text-white bg-transparent" for="pesquisaEstoque">Pesquisar o item do
                            estoque</label>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-floating">
                        <select class="form-select bg-warning" name="Ordem" id="ordemDeExibFiltro">
                            <option value="asc" selected>Recentes</option>
                            <option value="desc">Antigos</option>
                        </select>
                        <label for="ordemDeExibFiltro">Ordenar por mais:</label>
                    </div>
                </div>
            </div>
            <hr class="text-white" id="linhaHorizontal""></hr>
        <div class=" row gy-3">
            <div class="col-4">
                <div class="card text-bg-dark border-white shadow">
                    <div>
                        <div class="card-body fs-6">
                            <div class="row">
                                <div class="col-8">
                                    <h2 class="">Monitor Dell 120hz</h2>
                                </div>
                                <div class="col">
                                    <p class="text-center m-0">Quantidade:</p>
                                    <h2 class="text-center">2x</h2>
                                </div>
                            </div>
                            <div class="text-center">
                                <h2 class="fs-4">Status:</h2>
                                <span class="bg-danger p-1 rounded">Perdido</span>
                            </div>
                        </div>
                        <div class="espacoImagens position-relative border-top border-white overflow-hidden"
                            style="height: 175px;">
                            <div class="">
                                <button class="position-absolute z-1 start-0 ms-2 rounded-3 botoesSliders"
                                    onclick="retrocederCarrossel(this)" style="width: 20%;"><i
                                        class="bi bi-chevron-double-left fs-3 text-white"></i></button>
                                <button class="position-absolute z-1 end-0 me-2 rounded-3 botoesSliders"
                                    onclick="avancarCarrossel(this)" style="width: 20%;"><i
                                        class="bi bi-chevron-double-right fs-3 text-white"></i></button>
                            </div>
                            <div class="carrosselImagens">
                                <img class="trasicaoCarossel position-absolute img-fluid h-100 w-100 rounded-bottom object-fit-cover"
                                    type="image" data-estado="ativo"
                                    src="../../../database/storage/arquivosAnexos/anexoImagemAgendamentoId7_1.png"
                                    alt="">
                                <img class="opacity-0 position-absolute img-fluid h-100 w-100 rounded-bottom object-fit-cover"
                                    type="image" data-estado="escondido"
                                    src="../../../database/storage/arquivosAnexos/anexoImagemAgendamentoId55_103.png"
                                    alt="">
                                <img class="opacity-0 position-absolute img-fluid h-100 w-100 rounded-bottom object-fit-cover"
                                    type="image" data-estado="escondido"
                                    src="../../../database/storage/arquivosAnexos/anexoImagemAgendamentoId40_29.jpg"
                                    alt="">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>

    <!-- Scripts framework e específicos de cada página (se tiver) -->
    <!-- Jquery Lib -->
    <script src="../../../js/libs/jquery.min.js"></script>
    <!-- Bootstrap Framework -->
    <script src="../../../js/frameworks/bootstrap.bundle.min.js"></script>
    <!-- Script  -->
    <script src="../../../js/pages/estoque.js"></script>
</body>

</html>