document.addEventListener("change", function () {
  alteradorIconeStatus();
});

document.addEventListener("mouseover", function (elemento) {
  if (
    elemento.target.classList.contains("divButoes") ||
    elemento.target.classList.contains("butoesImagem")
  ) {
    let butoesImagem = elemento.target.querySelectorAll(".butoesImagem");

    butoesImagem.forEach((botao) => {
      botao.classList.remove("visually-hidden");
    });
  } else {
    let butoesImagem = document.querySelectorAll(".butoesImagem");

    butoesImagem.forEach((botao) => {
      botao.classList.add("visually-hidden");
    });
  }
});

function renderizarOpcoesMarcadas() {
  const tipoAgendamento = $("div[data-tiposalvo]").attr("data-tiposalvo");
  const statusAgendamento = $("div[data-statussalvo]").attr("data-statussalvo");

  if (tipoAgendamento === "Organização") {
    $("#tipoAgendamentoOrga").prop("checked", true);
  } else if (tipoAgendamento === "Manutenção") {
    $("#tipoAgendamentoManut").prop("checked", true);
  }

  switch (statusAgendamento) {
    case "pendente":
      $('option[value="pendente"]').prop("selected", true);
      break;
    case "realizado":
      $('option[value="realizado"]').prop("selected", true);
      break;
  }
  alteradorIconeStatus();
}

//Função de alteração de icone do span do input status
function alteradorIconeStatus() {
  const $iconeStatus = $("#iconeStatus");
  const $elementoStatus = $("#selectStatus");
  if ($elementoStatus.val() == "pendente") {
    $iconeStatus.attr("class", "bi bi-circle-fill text-warning");
    $elementoStatus.addClass("focus-ring");
  }
  if ($elementoStatus.val() == "realizado") {
    $iconeStatus.attr("class", "bi bi-check-circle-fill text-success");
  }
}

function expandirImagemFundo(botao) {
  let idInstancia = botao.id.substring(11);
  const zoomImage = document.querySelector("#imgFundo" + idInstancia);
  zoomImage.style.transform = "scale(1.5)";
}

function retrairImagemFundo(botao) {
  let idInstancia = botao.id.substring(11);
  const zoomImage = document.querySelector("#imgFundo" + idInstancia);
  zoomImage.style.transform = "none";
}

function acionarInputArquivo(id) {
  const $arquivoUpload = $("#arquivoUpload" + id);

  $arquivoUpload.click();
}

const urlParametros = new URLSearchParams(window.location.search);
const idAgendamento = urlParametros.get("idAgendamento");

const arquivosComIdsAlteradosPendentes = {};
function carregarArquivo(elementoInputComArquivo) {
  const arquivo = $(elementoInputComArquivo)[0].files[0];

  // Verifca se há arquivo enviado, evitando rodar a função sem arquivo.
  if (arquivo) {
    const id = $(elementoInputComArquivo).attr("data-idanexo");

    const localArquivoTemp = URL.createObjectURL(arquivo);
    const nomeArquivoSubstituido = $(elementoInputComArquivo).attr("data-arquivo");

    $("#imgFundo" + id).attr("src", localArquivoTemp);
    $("#imgModal" + id).attr("src", localArquivoTemp);

    arquivosComIdsAlteradosPendentes[id] = arquivo;
  }
}

const textosComIdAnexosAlteradosPendentes = {};
function carregarTextosAnexos(textoAnexoInstancia) {
  const textoInstancia = $(textoAnexoInstancia).val();
  const id = $(textoAnexoInstancia).attr("data-idanexo");

  textosComIdAnexosAlteradosPendentes[id] = textoInstancia;
}

function prepararFormdata() {
  const formData = new FormData();

  // Campos Tabela Agendamento
  formData.set("idAgendamento", idAgendamento);
  formData.set("dataAgendamento", $("#dataAgendamento").val());
  formData.set("tipoAgendamento", $("input[name='tipoAgendamento']").val());
  formData.set("conteudoAgendamento", $("#conteudoAgendamento").val());
  formData.set("envolvidosAgendamento", $("#envolvidosAgendamento").val());
  formData.set("statusAgendamento", $("#selectStatus").val());

  // Campos Tabela Anexos
  // Adiciona as chaves (IDs) separadamente no FormData
  Object.keys(textosComIdAnexosAlteradosPendentes).forEach((id, index) => {
    formData.append("idsTextosAlterados[]", id);
  });

  // Adiciona os valores (textos) separadamente no FormData
  Object.values(textosComIdAnexosAlteradosPendentes).forEach((texto, index) => {
    formData.append("textosAnexosAlterados[]", texto);
  });

  // Adiciona as chaves (IDs) separadamente no FormData
  Object.keys(arquivosComIdsAlteradosPendentes).forEach((id, index) => {
    formData.append("idsAnexosAlterados[]", id);
  });

  // Adiciona os valores (arquivos) separadamente no FormData
  Object.values(arquivosComIdsAlteradosPendentes).forEach((arquivo, index) => {
    formData.append("anexoArquivos[]", arquivo);
  });

  return formData;
}

async function salvarEdicao() {
  const formData = prepararFormdata();

  // Envia os dados do FormData para o PHP para salvar as alterações no banco de dados.
  try {
    const respostaJson = await $.ajax({
      url: "../../../php/actions/salvarEdicao.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
    });

    $("#statusSubmit").fadeIn();
    setTimeout(function () {
      $("#statusSubmit").fadeOut();
    }, 2000);
  } catch (erro) {
    $("#statusSubmit").attr("class", "text-bg-danger p-2 w-25 shadow rounded-2 fs-5 ms-2");
    $("#statusSubmit").text("ERRO AO SALVAR A EDIÇÃO!");
    $("#statusSubmit").fadeIn();
    setTimeout(function () {
      $("#statusSubmit").fadeOut();
    }, 2000);
  }
}

async function deletarAgendendamento() {
  try {
    const respostaJson = await $.ajax({
      url: "../../../php/actions/apagarAgendamento.php",
      type: "POST",
      data: {
        idAgendamento,
      },
    });

    $("#statusSubmit").attr("class", "text-bg-success p-2 w-25 shadow rounded-2 fs-5 ms-2");
    $("#statusSubmit").text(
      "SUCESSO EM APAGAR O AGENDAMENTO! REDIRECIONANDO PARA PÁGINA DE LISTAMENTO!"
    );
    $("#statusSubmit").fadeIn();
    setTimeout(function () {
      // window.location.href = "../../../php/pages/agendamentos/listarAgendamentos.php";
    }, 2000);
  } catch (erro) {
    $("#statusSubmit").attr("class", "text-bg-danger p-2 w-25 shadow rounded-2 fs-5 ms-2");
    $("#statusSubmit").text("ERRO AO APAGAR O AGENDAMENTO!");
    $("#statusSubmit").fadeIn();
    setTimeout(function () {
      $("#statusSubmit").fadeOut();
    }, 2000);
  }
}

$(document).ready(function () {
  renderizarOpcoesMarcadas();

  $(".uploadEscondido").change(function () {
    carregarArquivo(this);
  });

  $(".textosAnexos").change(function () {
    carregarTextosAnexos(this);
  });

  $("button#submitDelete").click(deletarAgendendamento);
  $("button#submit").click(salvarEdicao);
});

const $tooltipTriggerList = $('[data-bs-toggle="tooltip"]');
const tooltipList = [...$tooltipTriggerList].map(
  (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);
