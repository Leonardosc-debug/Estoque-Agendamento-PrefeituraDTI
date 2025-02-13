function alteradorIconeStatus() {
  let $iconeStatus = $("#iconeStatus");
  let elementoStatus = $("#inputStatus").val().toLowerCase();

  switch (elementoStatus) {
    case "pendente":
      $iconeStatus.attr("class", "bi bi-exclamation-circle-fill text-warning");
      break;
    case "realizado":
      $iconeStatus.attr("class", "bi bi-check-circle-fill text-success");
      break;
    default:
      $iconeStatus.attr("class", "bi bi-tag text-white");
  }
}

function alteradorIconeTipo() {
  let $iconeStatus = $("#iconeTipo");
  let elementoStatus = $("#inputTipo").val().toLowerCase();

  switch (elementoStatus) {
    case "manutenção":
      $iconeStatus.attr("class", "bi bi-tools text-white");

      break;
    case "organização":
      $iconeStatus.attr("class", "bi bi-box-seam-fill text-white");

      break;
    default:
      $iconeStatus.attr("class", "bi bi-journal text-white");
  }
}

function liberarDateAte(elementoHtml) {
  const valorInput = $(elementoHtml).val();
  if (valorInput !== "") {
    $("#inputDataAte").prop("disabled", false);
  } else {
    $("#inputDataAte").prop("disabled", true);
    $("#inputDataAte").val("");
  }
}

function limparFiltros() {
  $("#inputConteudo").val("");
  $("#inputTipo").val("");
  $("#inputStatus").val("");
  $("#inputData").val("");
  $("#inputDataAte").val("");

  alteradorIconeStatus();
  alteradorIconeTipo();
  $("#inputDataAte").prop("disabled", true);
}

async function consultaSql() {
  try {
    const respostaJSON = await $.ajax({
      url: "../../../php/actions/consultarAgendamentos.php",
      type: "POST",
      data: {
        conteudoFiltro: $("#inputConteudo").val(),
        tipoFiltro: $("#inputTipo").val(),
        statusFiltro: $("#inputStatus").val(),
        dataFiltro: $("#inputData").val(),
        dataAteFiltro: $("#inputDataAte").val(),
      },
      dataType: "json",
    });

    return respostaJSON;
  } catch (erro) {
    const $divTabela = $("#divTabela");

    $divTabela.empty();
    $divTabela.append(
      `<h1 class="text-center fs-3">A página não conseguiu obter os agendamentos do servidor.</h1>`
    );

    return [];
  }
}

const maxAgendamentoPorPagina = 9;
const maxSecoesPaginas = 10;
let numeroDePaginas;
let indexAtual;

function montarPaginacao(quantidadeAgendamentos) {
  numeroDePaginas = Math.ceil(quantidadeAgendamentos / maxAgendamentoPorPagina);

  $("#seletorPaginacao").remove();

  const $nav = $("<nav>", {
    id: "seletorPaginacao",
  });

  const $ul = $("<ul>", {
    class: "pagination justify-content-center",
  });

  const $liBtnAnterior = $("<li>", {
    class: "page-item",
  }).append(
    $("<button>", {
      class: "page-link disabled",
      text: "Anterior",
      "data-action": "prev",
    })
  );

  const $liBtnProxima = $("<li>", {
    class: "page-item",
  }).append(
    $("<button>", {
      class: "page-link disabled",
      text: "Próxima",
      "data-action": "next",
    })
  );

  $ul.append($liBtnAnterior);
  for (let i = 1; i <= numeroDePaginas; i++) {
    const $liBtnQuantResponsivo = $("<li>", {
      class: "page-item",
    }).append(
      $("<button>", {
        class: "page-link",
        "data-page": i,
        text: i,
      })
    );
    if (i > maxSecoesPaginas) {
      $liBtnQuantResponsivo.find("button").hide();
    }

    $ul.append($liBtnQuantResponsivo);
  }
  $ul.append($liBtnProxima);
  $nav.append($ul);
  $("#tabela").parent().append($nav);

  if (numeroDePaginas > maxSecoesPaginas) {
    $('button[data-action="next"]').removeClass("disabled");
  }
}

function trazerPraTabela(arrayAgendamentos) {
  console.log("renderizou");
  // Limpa o conteúdo atual da tabela
  $("#tabela tbody").empty();

  // Itera sobre cada agendamento
  $.each(arrayAgendamentos, function (chave, valor) {
    // Cria a nova linha
    const novaLinha = $("<tr>");

    // Adiciona ícone de status dependendo do valor de statusAgendamento
    let iconeStatus = "";
    switch (valor.statusAgendamento) {
      case "pendente":
        iconeStatus = '<i class="bi bi-exclamation-circle-fill text-warning" title="Pendente"></i>';
        break;
      case "realizado":
        iconeStatus = '<i class="bi bi-check-circle-fill text-success" title="Realizado"></i>';
        break;
      default: // Caso não seja "pendente" ou "realizado"
        iconeStatus = '<i class="bi bi-x-circle text-warning" title="Sem status"></i>';
        break;
    }

    // Monta cada célula da linha
    novaLinha.append(`
      <th>${valor.idAgendamento}</th>
      <td style="width: 0px;">${iconeStatus}</td>
      <td>${valor.dataAgendamento}</td>
      <td>${valor.tipoAgendamento}</td>
      <td>${valor.conteudoAgendamento}</td>
      <td class="truncar">${valor.envolvidosAgendamento}</td>
      <td>Implementar</td>
    `);

    // Adiciona os links para edição e detalhes
    const links = `
      <div class="d-flex gap-2">
        <a href="../../../php/pages/agendamentos/editarAgendamento.php?idAgendamento=${valor.idAgendamento}" target="_blank">
          <i class="bi bi-pencil-square text-black"></i>
        </a>
        <a href="../../../php/actions/apagarAgendamento.php?idAgendamento=${valor.idAgendamento}" target="_self">
          <i class="bi bi-calendar2-x-fill text-danger"></i>
        </a>
        <a href="../../../php/pages/agendamentos/verDetalhes.php?idAgendamento=${valor.idAgendamento}" target="_blank">
          <i class="bi bi-arrows-angle-expand"></i>
        </a>
      </div>
    `;
    novaLinha.append(`<td style="width: 0px;">${links}</td>`);

    // Adiciona a linha na tabela
    $("#tabela tbody").append(novaLinha);
  });
}

async function renderizarElementos(quais) {
  try {
    const arrayResultante = await consultaSql();
    const quantidadeAgendamentos = arrayResultante.length;
    let arrayLimitado;

    switch (quais) {
      case "todos":
        indexAtual = 1;
        arrayLimitado = arrayResultante.slice(
          (indexAtual - 1) * maxAgendamentoPorPagina,
          indexAtual * maxAgendamentoPorPagina
        );

        montarPaginacao(quantidadeAgendamentos);
        $("#seletorPaginacao").prepend(`<p class="m-0"></p>`);
        marcarIndexAtual();

        break;
      case "tabela":
        arrayLimitado = arrayResultante.slice(
          (indexAtual - 1) * maxAgendamentoPorPagina,
          indexAtual * maxAgendamentoPorPagina
        );

        break;
    }

    trazerPraTabela(arrayLimitado);
    // Adicionará o contador de agendamentos mostrantes na tela da quantidade que existe
    const quantidadeExibida = arrayResultante.slice(0, indexAtual * maxAgendamentoPorPagina).length;
    contadorAgendamentosExibidos(quantidadeExibida, quantidadeAgendamentos);
  } catch (erro) {
    console.log("Ocorreu um erro ao montar a paginacão.", erro);
  }
}

function contadorAgendamentosExibidos(quantidadeExibida, quantidadeAgendamentos) {
  let $conteudoTexto;
  let filtro = false;

  if (
    $("#inputConteudo").val() !== "" ||
    $("#inputTipo").val() !== "" ||
    $("#inputStatus").val() !== "" ||
    $("#inputData").val() !== "" ||
    $("#inputDataAte").val() !== ""
  ) {
    filtro = true;
  }

  if (filtro) {
    $conteudoTexto = `Mostrando ${quantidadeExibida} de ${quantidadeAgendamentos} agendamentos <span class="text-danger">filtrados<span>.`;
  } else {
    $conteudoTexto = `Mostrando ${quantidadeExibida} de ${quantidadeAgendamentos} agendamentos.`;
  }

  $("#seletorPaginacao p").html($conteudoTexto);
}

function marcarIndexAtual() {
  $("button.page-link.active").removeClass("active");

  $("button[data-page]")
    .filter(function () {
      return parseInt($(this).attr("data-page")) === indexAtual;
    })
    .addClass("active");
}

let paginacao = 0;
function esconderMostrarIndexsPorPaginacao(valorClicado) {
  const btnProximo = $('button[data-action="next"]');
  const btnAnterior = $('button[data-action="prev"]');
  let contador = 0;

  switch (valorClicado) {
    case "next":
      contador = 0;
      paginacao++;

      btnAnterior.removeClass("disabled");

      $("button[data-page]").each(function () {
        let numeroInstancia = parseInt($(this).attr("data-page"));

        if (numeroInstancia <= maxSecoesPaginas * paginacao) {
          $(this).hide();
        }

        if (
          numeroInstancia > maxSecoesPaginas * paginacao &&
          numeroInstancia <= maxSecoesPaginas * (paginacao + 1)
        ) {
          $(this).show();
          contador++;
        }
      });

      break;
    case "prev":
      contador = 0;
      paginacao--;

      if (paginacao <= 0) {
        $("button[data-page]").each(function () {
          btnAnterior.addClass("disabled");
          let numeroInstancia = parseInt($(this).attr("data-page"));

          if (numeroInstancia <= maxSecoesPaginas) {
            $(this).show();
            contador++;
          }

          if (numeroInstancia > maxSecoesPaginas) {
            $(this).hide();
          }
        });
      } else {
        btnProximo.removeClass("disabled");

        $("button[data-page]").each(function () {
          let numeroInstancia = parseInt($(this).attr("data-page"));

          if (numeroInstancia <= maxSecoesPaginas * paginacao) {
            $(this).hide();
          }

          if (
            numeroInstancia > maxSecoesPaginas * paginacao &&
            numeroInstancia <= maxSecoesPaginas * (paginacao + 1)
          ) {
            $(this).show();
            contador++;
          } else {
            $(this).hide();
          }
        });
      }

      break;
  }

  if (contador < maxSecoesPaginas && paginacao > 0) {
    btnProximo.addClass("disabled");
  } else {
    btnProximo.removeClass("disabled");
  }
}

$(document).ready(() => {
  // Inicia a página já com os elementos na tabela
  renderizarElementos("todos").then(() => {
    // Delegação de eventos: aplicando os cliques nos botões de navegação
    $("#divTabela").on("click", 'button[data-action="next"]', function () {
      esconderMostrarIndexsPorPaginacao("next");
    });

    $("#divTabela").on("click", 'button[data-action="prev"]', function () {
      esconderMostrarIndexsPorPaginacao("prev");
    });

    // Delegação de eventos para os botões de página
    $("#divTabela").on("click", "button[data-page]", function () {
      indexAtual = parseInt($(this).attr("data-page"));

      renderizarElementos("tabela");
      marcarIndexAtual();
    });
  });

  $("form").submit(() => {
    renderizarElementos("todos");

    return false;
  });
});
