// Variavéis globais
let contatadorAgendamentoRealizado = 0;

function mostrarAbaAnexos() {
  const $valorSwitch = $("#flexSwitchMostrarAnexos").prop("checked");
  const $colunaEsquerda = $("#colunaEsquerda");
  const $colunaDireita = $("#colunaDireita");

  if ($valorSwitch) {
    $colunaEsquerda.removeClass("visually-hidden");
    $colunaDireita.addClass("rounded-start-0");
  } else {
    $colunaEsquerda.addClass("visually-hidden");
    $colunaDireita.removeClass("rounded-start-0");
  }
}

function alteradorIconeStatus() {
  const $iconeStatus = $("#iconeStatus");
  const $elementoStatus = $("#selectStatus");

  if ($elementoStatus.val() === "pendente") {
    $iconeStatus.attr("class", "bi bi-exclamation-circle-fill text-warning");
  }
  if ($elementoStatus.val() === "realizado") {
    $iconeStatus.attr("class", "bi bi-check-circle-fill text-success");
  }
}

function validarArquivo(input) {
  const tipoArquivosAceitos = ["image/jpeg", "image/jpg", "image/png"];
  const limiteTamanhoArquivosUpload = 10 * 1024 * 1024;
  const arquivoInstancia = input.files[0];
  // Encontra o índice do input atual
  const indexAtual = $('[name="anexoArquivo"]').index(input);
  let erro = false;
  let $mensagemErro;

  if (arquivoInstancia) {
    const tipoArquivo = arquivoInstancia.type;
    const tamanhoArquivo = arquivoInstancia.size;

    if (!tipoArquivosAceitos.includes(tipoArquivo)) {
      $mensagemErro = $("<p>", {
        class: "text-danger mb-0",
        style: "font-size: 12px",
        text: `Formato do arquivo "${arquivoInstancia.name}" é inválido. É aceito somente imagens dos tipos: .jpg, .jpeg e .png`,
      });
      erro = true;
    } else if (tamanhoArquivo > limiteTamanhoArquivosUpload) {
      $mensagemErro = $("<p>", {
        class: "text-danger mb-0",
        style: "font-size: 12px",
        text: `O tamanho do arquivo "${arquivoInstancia.name}" excede o limite permitido de 10MB. Por favor, tente comprimir o arquivo ou escolha outro que esteja dentro do limite.`,
      });
      erro = true;
    }

    if (erro) {
      $(input).siblings("p").remove(); // Remove o aviso anterior
      $(input).after($mensagemErro);
      $(input).val(""); // Limpa o input
      $(input).addClass("is-invalid");
      $(input).siblings("textarea").prop("disabled", true);

      const $proximosInputs = $('[name="anexoArquivo"]').slice(indexAtual + 1);

      // Desabilita os próximos inputs
      $proximosInputs.val("");
      $proximosInputs.prop("disabled", true);
      $proximosInputs.removeClass("is-invalid");
      $proximosInputs.siblings("textarea").prop("disabled", true);
      $proximosInputs.siblings("p").remove();
    } else {
      const $textAreaDoInput = $(input).siblings("textarea");
      // Encontra o próximo input (com base no índice)
      const nextInput = $('[name="anexoArquivo"]').eq(indexAtual + 1);

      // Remove os avisos de erro
      $(input).removeClass("is-invalid");
      $(input).siblings("p").remove();

      // Verifica se o próximo input existe e o habilita
      if (nextInput.length) {
        nextInput.prop("disabled", false); // Habilita o próximo input
      }

      $textAreaDoInput.prop("disabled", false);
    }
  }
}

function resetarFormulario() {
  $("form").trigger("reset");
  $('[name="textoAnexo"]').slice(0).prop("disabled", true); // Disabilitará os inputs de textos a partir do primeiro
  $('[name="anexoArquivo"]').slice(1).prop("disabled", true); // Disabilitará os inputs de arquivos a partir do segundo input
}

function prepararFormdata() {
  // Pegando os valores e colocando nas variaveis para manipulação e envio
  const dataAgendamento = $("#dataAgendamento").val();
  const tipoAgendamento = $("input[name='tipoAgendamento']:checked").val();
  const conteudoAgendamento = $("#conteudoAgendamento").val();
  const envolvidosAgendamento = $("#envolvidosAgendamento").val();
  const statusAgendamento = $("#selectStatus").val();

  // Validações dos campos obrigatórios - Client-Side
  let existeCampoInvalido = false;
  if (dataAgendamento === "" || dataAgendamento === null) {
    $("#dataAgendamento").addClass("is-invalid");
    existeCampoInvalido = true;
  } else {
    $("#dataAgendamento").removeClass("is-invalid");
  }
  if (conteudoAgendamento === "" || conteudoAgendamento === null) {
    $("#conteudoAgendamento").addClass("is-invalid");
    existeCampoInvalido = true;
  } else {
    $("#conteudoAgendamento").removeClass("is-invalid");
  }
  if (statusAgendamento === "" || statusAgendamento === null) {
    $("#selectStatus").addClass("is-invalid");
    existeCampoInvalido = true;
  } else {
    $("#selectStatus").removeClass("is-invalid");
  }
  if (existeCampoInvalido) {
    alert("Esses seguintes campos obrigatórios faltaram de ser preenchidos:");
    return false;
  }

  // Adicionando os campos ao FormData
  const formData = new FormData();
  formData.append("dataAgendamento", dataAgendamento);
  formData.append("tipoAgendamento", tipoAgendamento);
  formData.append("conteudoAgendamento", conteudoAgendamento);
  formData.append("envolvidosAgendamento", envolvidosAgendamento);
  formData.append("statusAgendamento", statusAgendamento);
  // Adicionando os anexos ao FormData
  $('[name="anexoArquivo"]').each(function () {
    if ($(this)[0].files.length && !$(this).prop("disabled")) {
      // Verifica se há o arquivo, se tiver adiciona ao FormData
      const anexoArquivo = $(this)[0].files[0];
      formData.append("anexoArquivos[]", anexoArquivo); //Cria um array dentro do FormData e adiciona o arquivo atual do loop nele
    }
  });
  // Adicionando o texto do anexo ao FormData
  $('[name="textoAnexo"]').each(function () {
    const textoAnexo = $(this).val();

    if (!$(this).prop("disabled")) {
      formData.append("textosAnexos[]", textoAnexo); //Cria um array dentro do FormData e adiciona o texto atual do loop nele
    }
  });

  return formData;
}

async function salvarAgendamento() {
  const formData = prepararFormdata();
  contatadorAgendamentoRealizado++;

  console.log(...formData.entries());

  try {
    const retornoJson = await $.ajax({
      url: "../../../php/actions/salvarAgendamento.php",
      method: "POST",
      data: formData,
      contentType: false,
      processData: false,
    });
    const $avisoRodapeSucesso = $("<p>", {
      class: "text-bg-success align-content-center border-2 border-bottom m-0 pt-2 pb-2",
      text: `O ${contatadorAgendamentoRealizado}° agendamento foi realizado com sucesso!`,
    });

    // Limpando o formulário e os inputs dos anexos e devolvendo as restrições
    resetarFormulario();

    $("#statusSubmit").fadeIn().append($avisoRodapeSucesso);
    setTimeout(function () {
      $("#statusSubmit").fadeOut("Slow");
    }, 5000);
  } catch (erro) {
    const $avisoRodapeFalha = $("<p>", {
      class: "text-bg-danger align-content-center border-2 border-bottom m-0 pt-2 pb-2",
      text: `O salvamento do ${contatadorAgendamentoRealizado}° agendamento falhou! Tente novamente.`,
    });

    $("#statusSubmit").fadeIn().append($avisoRodapeFalha);
    setTimeout(function () {
      $("#statusSubmit").fadeOut("Slow");
    }, 5000);
  }
}

// Event Listeners
$("form").submit(function (evento) {
  evento.preventDefault();
  salvarAgendamento();
});
