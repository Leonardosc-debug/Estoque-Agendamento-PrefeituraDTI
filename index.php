<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Agendamento</title>
    <link rel="shortcut icon" href="./images/global/logo.png" type="image/x-icon" />
    <!-- CSS Génerico e Específico de cada página (se tiver) -->
    <link rel="stylesheet" href="./css/global.css" />
  </head>

  <body>
    <header>
      <!-- Barra topo da tela -->
      <nav
        class="fixed-top navbar navbar-expand-lg"
        data-bs-theme="dark"
        style="background-color: green"
      >
        <div class="container-fluid">
          <a class="navbar-brand" href="index.html">
            <img src="./IMG/logo.png" width="30" />
            DTI
          </a>
          <button
            class="navbar-toggler me-3"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarConteudo"
            aria-controls="navbarTogglerDemo02"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarConteudo">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="./php/pages/login/login.php">Login</a>
              </li>
              <li class="nav-item"></li>
              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle active"
                  href="#"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                  >Agendamentos</a
                >
                <ul class="dropdown-menu dropdown-menu-dark w-25">
                  <li>
                    <a class="dropdown-item" href="./php/pages/agendamentos/listarAgendamentos.php"
                      ><i class="bi bi-card-list"></i> Listar</a
                    >
                  </li>
                  <li>
                    <a class="dropdown-item" href="./php/pages/agendamentos/agendar.php"
                      ><i class="bi bi-calendar2-plus-fill"></i> Agendar</a
                    >
                  </li>
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

    <main class="mt-5 pt-3">
      <h1>TESTE</h1>
    </main>

    <script src="./js/frameworks/bootstrap.bundle.min.js"></script>
  </body>
</html>
