<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar</title>
    <link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">
    <!-- JQuery -->
    <script type="text/javascript" src="./js/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/bootstrap-icons.css">
    <!-- CSS Génerico e Específico de cada página (se tiver) -->
    <link rel="stylesheet" href="./css/padrao.css">
    <link rel="stylesheet" href="./css/agendar.css">
</head>

<body class="bg-dark">

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

    <!-- Formulário para agendamento -->
    <main class="container align-content-center" style="height: 90vh;">
        <h1 class="text-white text-center" style="-webkit-text-fill-color: transparent; -webkit-text-stroke: 1px;">
            AGENDAR</h1>
        <div class="row justify-content-center">
            <div class="col-11 col-md p-3 shadow bg-secondary-subtle border-0 rounded">
                <form class="row">
                    <div class="col-sm visually-hidden overflow-auto" id="colunaEsquerda" style="max-height: 700px;">
                        <div class="mb-3" id="grupoAnexos">
                            <label for="inputAnexo1">Anexo 1:</label>
                            <input class="form-control ms-2 mt-0" name="anexoArquivo" type="file"
                                onchange="validarTipoArquivo(this)" accept=".jpg, .jpeg, .png">
                        </div>
                    </div>
                    <div class="col overflow-auto" id="colunaDireita" style="max-height: 700px;">
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

    <script src="./js/agendar.js"></script>
    <script type="text/javascript">
    let contatadorAgendamentoRealizado = 0;
    $("#statusSubmit").hide();
    $(document).ready(function() {
        $("form").submit(function(evento) {
            evento.preventDefault();
            // Pegando os valores e colocando nas variaveis para manipulação e envio
            let dataAgendamento = $("#dataAgendamento").val();
            let tipoAgendamento = $("input[name='tipoAgendamento']:checked").val();
            let conteudoAgendamento = $("#conteudoAgendamento").val();
            let envolvidosAgendamento = $("#envolvidosAgendamento").val();
            let statusAgendamento = $("#selectStatus").val();


            // Validações dos campos obrigatórios - Client-Side

            let existeCampoInvalido = false;
            if (dataAgendamento === "" || dataAgendamento === null) {
                $("#dataAgendamento").addClass("is-invalid");
                existeCampoInvalido = true;
            } else {
                $("#dataAgendamento").removeClass("is-invalid");
            };
            if (conteudoAgendamento === "" || conteudoAgendamento === null) {
                $("#conteudoAgendamento").addClass("is-invalid");
                existeCampoInvalido = true;
            } else {
                $("#conteudoAgendamento").removeClass("is-invalid");
            };
            if (envolvidosAgendamento === "" || existeCampoInvalido === null) {
                envolvidosAgendamento = "Nenhum citado...";
            };
            if (statusAgendamento === "" || statusAgendamento === null) {
                $("#selectStatus").addClass("is-invalid");
                existeCampoInvalido = true;
            } else {
                $("#selectStatus").removeClass("is-invalid");
            };
            if (existeCampoInvalido) {
                alert("Esses seguintes campos obrigatórios faltaram de ser preenchidos:");
                return false;
            };

            // AVISO: Colocar dentro da validação dos campos obrigatórios
            // Adicionando os campos ao FormData
            let formData = new FormData();
            formData.append("dataAgendamento", dataAgendamento);
            formData.append("tipoAgendamento", tipoAgendamento);
            formData.append("conteudoAgendamento", conteudoAgendamento);
            formData.append("envolvidosAgendamento", envolvidosAgendamento);
            formData.append("statusAgendamento", statusAgendamento);
            // Adicionando os anexos ao FormData
            $('[name="anexoArquivo"]').each(function() {
                if ($(this)[0].files.length >
                    0) { // Verifica se há o arquivo, se tiver adiciona ao FormData
                    let arquivo = $(this)[0].files;
                    formData.append("anexoArquivos[]", arquivo[
                        0
                    ]); //Cria um array dentro do FormData e adiciona o arquivo atual do loop nele
                }
            });
            // Adicionando o texto do anexo ao FormData
            $(".textoAnexo").each(function() {
                let textoAnexo = $(this).val();
                formData.append("textosAnexos[]",
                    textoAnexo
                ); //Cria um array dentro do FormData e adiciona o texto atual do loop nele
            })

            $.ajax({
                url: "salvarAgendamento.php",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(result) {
                    contatadorAgendamentoRealizado++;
                    $("form").trigger("reset");
                    $("#statusSubmit").fadeIn().append(
                        `<p class="text-bg-success align-content-center border-2 border-bottom m-0 pt-2 pb-2">O ${contatadorAgendamentoRealizado}° agendamento foi realizado com sucesso!</p>`
                    );
                    setTimeout(function() {
                        $('#statusSubmit').fadeOut('Slow');
                    }, 5000);
                },
                error: function(xhr, status, error) {
                    let respostaJson = xhr.responseJSON;
                    console.log(status);
                    console.log(xhr);
                    console.log(respostaJson);
                    let mensagemErro = "a um erro";
                    $.each(respostaJson, function(chave, valor) {
                        if ((chave == "extensao") && (valor == "invalido")) {
                            mensagemErro =
                                `ao erro de tentar enviar um arquivo com uma extensão inválida, os formatos aceitos são: png, jpeg e jpg!`;
                        }
                    });
                    contatadorAgendamentoRealizado++;
                    $("#statusSubmit").fadeIn().append(
                        `<p class="text-bg-danger align-content-center border-2 border-bottom m-0 pt-2 pb-2">O ${contatadorAgendamentoRealizado}° agendamento não foi realizado devido  ${mensagemErro}!</p>`
                    );
                    setTimeout(function() {
                        $('#statusSubmit').fadeOut('Slow');
                    }, 5000);
                    console.log("Error: " + error);
                }
            })
        })
    });
    </script>
    <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html>