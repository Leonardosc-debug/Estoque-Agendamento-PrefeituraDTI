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
  const tipoAgendamento = "<?php echo $dadosEmColunasAgendamento['tipoAgendamento']; ?>";
  const statusAgendamento = "<?php echo $dadosEmColunasAgendamento['statusAgendamento']; ?>";

  if (tipoAgendamento == "Organização") {
    document.getElementById("tipoAgendamentoOrga").checked = true;
  } else if (tipoAgendamento == "Manutenção") {
    document.getElementById("tipoAgendamentoManut").checked = true;
  }

  switch (statusAgendamento) {
    case "pendente":
      document.querySelector('option[value="pendente"').setAttribute("selected", "true");
      break;
    case "realizado":
      document.querySelector('option[value="realizado"').setAttribute("selected", "true");
      break;
  }
}

//Função de alteração de icone do span do input status
function alteradorIconeStatus() {
  const $iconeStatus = $("#iconeStatus");
  const $elementoStatus = $("#selectStatus");
  if ($elementoStatus.value == "pendente") {
    $iconeStatus = "bi bi-circle-fill text-warning";
    $elementoStatus.classList.add("focus-ring");
  }
  if ($elementoStatus.value == "realizado") {
    $iconeStatus.classList = "bi bi-check-circle-fill text-success";
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

const idAgendamento = "<?php echo $idAgendamento; ?>";
let formData = new FormData();

function carregarArquivoFormData(elementoInputComArquivo) {
  const arquivo = $(elementoInputComArquivo)[0].files[0];

  // Verifca se há arquivo enviado, evita rodar a função sem arquivo.
  if (arquivo.length > 0) {
    const id = $(elementoInputComArquivo).attr("id").replace(/[^\d]/g, "");

    const localArquivoTemp = URL.createObjectURL(arquivo);
    const nomeArquivoSubstituido = $(elementoInputComArquivo).attr("data-arquivo");

    $("#imgFundo" + id).attr("src", localArquivoTemp);
    $("#imgModal" + id).attr("src", localArquivoTemp);

    formData.set("nomesImagensAlterados[]", nomeArquivoSubstituido);
    formData.set("anexoArquivos[]", arquivo);
  }
}

function carregarTextosAnexos() {
  const textoInstancia = $(this).val();
  const id = $(this).attr("id").replace(/[^\d]/g, "");

  textosEIdAnexosAlterados[id] = textoInstancia;
}

async function salvarEdicao() {
  formData.append("idAgendamento", idAgendamento);

  try {
    const resposta = await $.ajax({
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
  $.ajax({
    url: "apagarAgendamento.php",
    type: "POST",
    data: {
      idAgendamento,
    },
    error: function (respostaJson) {
      $("#statusSubmit").attr("class", "text-bg-danger p-2 w-25 shadow rounded-2 fs-5 ms-2");
      $("#statusSubmit").text("ERRO AO APAGAR O AGENDAMENTO!");
      $("#statusSubmit").fadeIn();
      setTimeout(function () {
        $("#statusSubmit").fadeOut();
      }, 2000);
    },
  });
}

const textosEIdAnexosAlterados = {};

$(document).ready(function () {
  renderizarOpcoesMarcadas();

  $(".uploadEscondido").change(function () {
    carregarArquivoFormData(this);
  });

  $(".textosAnexos").change(function () {});

  //Adicionará para envio apenas aqueles campos que foram modificados
  $("#dataAgendamento").change(function () {
    formData.set("dataAgendamento", $(this).val());
  });
  $("input[name='tipoAgendamento']").change(function () {
    formData.set("tipoAgendamento", $(this).val());
  });
  $("#conteudoAgendamento").change(function () {
    formData.set("conteudoAgendamento", $(this).val());
  });
  $("#envolvidosAgendamento").change(function () {
    formData.set("envolvidosAgendamento", $(this).val());
  });
  $("#selectStatus").change(function () {
    formData.set("statusAgendamento", $(this).val());
  });

  $("button#submitDelete").click(deletarAgendendamento);
  $("button#submit").click(salvarEdicao);
});

const $tooltipTriggerList = $('[data-bs-toggle="tooltip"]');
const tooltipList = [...$tooltipTriggerList].map(
  (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);
