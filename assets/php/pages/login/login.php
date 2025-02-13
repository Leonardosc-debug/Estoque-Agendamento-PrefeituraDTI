<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento</title>
    <link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/bootstrap-icons.css">
    <!-- CSS Génerico e Específico de cada página (se tiver) -->
    <link rel="stylesheet" href="./css/padrao.css">
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>

    <!-- Barra topo da tela -->
    <header class="sticky-top navbar navbar-expand-lg" data-bs-theme="dark" style="background-color: green;">
        <nav class="container-fluid">
            <a class="navbar-brand" href="home.php">
                <img src="./IMG/logo.png" width="30">
                DTI
            </a>
            <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarConteudo"
                aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
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
                            <li><a class="dropdown-item" href="./agendamentos.php"><i class="bi bi-card-list"></i>
                                    Listar</a></li>
                            <li><a class="dropdown-item" href="./agendar.php"><i class="bi bi-calendar2-plus-fill"></i>
                                    Agendar</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="estoque.php">Estoque</a>
                    </li>
                </ul>
        </nav>
    </header>

    <!-- Form de login-->
    <main class="d-flex justify-content-center align-items-center" style="height: 90vh;">
        <div id="cardDoLogin" class="card border-primary" style="width: 22rem;">
            <div class="card-header text-center fw-bold fs-4">
                LOGIN
            </div>
            <form class="card-body needs-validation" onsubmit="return validacaoLogin()" novalidate method="post">
                <div class="mb-3">
                    <label for="inputLoginEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="inputLoginEmail"
                        placeholder="Insira o email cadastrado..." required>
                </div>
                <div>
                    <label for="inputLoginPassword" class="form-label">Senha</label>
                    <div class="input-group mb-1">
                        <input type="password" class="form-control" data-input="senha" id="inputLoginPassword"
                            placeholder="Insira a senha cadastrada..." required>
                        <button type="button" class="input-group-text" data-id="inputLoginPassword"
                            onmousedown="revelarSenha(this)" onmouseup="ocultarSenha(this)"><img src="./svg/eye.svg"
                                alt="" srcset=""></button>
                        <scan id="validationErrorSenha" class="invalid-tooltip">A Senha precisa conter pelo menos 8
                            caracteres, uma letra maiúscula, uma letra minúscula, um número e um caractere especial.
                        </scan>
                    </div>
                </div>
                <div class="mb-4 d-flex justify-content-end">
                    <button type="button" id="btnEsqueci" data-bs-toggle="modal"
                        data-bs-target="#caixaEsquecimento">Esqueci
                        minha senha</button>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal"
                        data-bs-target="#caixaRegistro">Registrar-se</button>
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </div>
            </form>
        </div>
    </main>

    <!-- Modal de Registro-->
    <div class="modal fade" id="caixaRegistro" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-center" id="cabecalhoModal">Solicitação de registro</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body needs-validation" onsubmit="return validacaoRegistro()" novalidate
                    method="post">
                    <p style="font-size: 13px;">Após clicar em "registrar" um email de confirmação será enviado para o
                        email do usuário. Após a confirmação, será preciso aguardar a aceitação do registro do usuário.
                    </p>
                    <div class="mb-3">
                        <label for="inputRegisterName" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="inputRegisterName"
                            placeholder="Insira seu nome completo..." required>
                    </div>
                    <div class="mb-3 has-validation">
                        <label for="inputRegisterEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="inputRegisterEmail"
                            placeholder="Insira um email válido..." required>
                    </div>
                    <div class="mb-3">
                        <label for="inputRegisterPassword" class="form-label">Senha</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="inputRegisterPassword"
                                oninput="vericarCondicaoRegistro()" placeholder="Insira uma senha válida aqui..."
                                required>
                            <button type="button" class="input-group-text" data-id="inputRegisterPassword"
                                onmousedown="revelarSenha(this)" onmouseup="ocultarSenha(this)"><img src="./svg/eye.svg"
                                    alt="" srcset=""></button>
                        </div>
                        <span class="" style="font-weight: bold;">•</span> <span class="form-text"
                            id="spanRegisterPassword" style="font-size: 13px;">A Senha precisa conter pelo menos 8
                            caracteres, uma letra maiúscula, uma letra minúscula, um número e um caractere especial.
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="inputRegisterConfirmPassword" class="form-label">Confirme a senha</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="inputRegisterConfirmPassword"
                                placeholder="Repita a senha anteriormente digitada..." oninput="" required>
                            <button type="button" class="input-group-text" data-id="inputRegisterConfirmPassword"
                                onmousedown="revelarSenha(this)" onmouseup="ocultarSenha(this)"><img src="./svg/eye.svg"
                                    alt="" srcset=""></button>
                            <span class="invalid-feedback">A senha não é idêntica a anteriormente digitada.</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">Registrar +</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Esqueci a senha-->
    <div class="modal fade" id="caixaEsquecimento" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-center" id="cabecalhoModal">Recuperação de senha</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" novalidate onsubmit="return validarEsqueci()" method="post">
                    <p style="font-size: 13px;">Após clicar em "enviar" um email de recuperação de senha será enviado
                        caso exista esse email no sistema.
                    </p>
                    <div class="mb-3">
                        <label for="inputForgetEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="inputForgetEmail"
                            placeholder="Insira o email de recuperação..." required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="fixed-bottom"></footer>

    <script src="./js/main.js"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html>