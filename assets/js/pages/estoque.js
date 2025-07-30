function avancarCarrossel(input) {
  const divPai = $(input).closest(".espacoImagens");
  const carrosselImagens = divPai.find(".carrosselImagens");
  const imagemAtiva = carrosselImagens.find('img[data-estado="ativo"]');
  let proximaImagem = imagemAtiva.next();

  if (!proximaImagem.length) {
    proximaImagem = carrosselImagens.find("img").first();
  }

  imagemAtiva.css("transform", "translateX(100%)");
  imagemAtiva.attr("data-estado", "escondido");

  proximaImagem.removeClass("opacity-0");
  proximaImagem.removeClass("trasicaoCarossel");
  proximaImagem.css("transform", "translateX(-100%)");

  setTimeout(function () {
    proximaImagem.addClass("trasicaoCarossel");
    proximaImagem.css("transform", "translateX(0%)");
    proximaImagem.attr("data-estado", "ativo");
  }, 0.2);

  proximaImagem.one("transitionend", function () {
    $('[data-estado="escondido"]').addClass("opacity-0");
  });
}

function retrocederCarrossel(input) {
  const divPai = $(input).closest(".espacoImagens");
  const carrosselImagens = divPai.find(".carrosselImagens");
  const imagemAtiva = carrosselImagens.find('img[data-estado="ativo"]');
  let passadaImagem = imagemAtiva.prev();

  if (!passadaImagem.length) {
    passadaImagem = carrosselImagens.find("img").last();
  }

  console.log(passadaImagem);

  imagemAtiva.css("transform", "translateX(-100%)");
  imagemAtiva.attr("data-estado", "escondido");

  passadaImagem.removeClass("opacity-0");
  passadaImagem.removeClass("trasicaoCarossel");
  passadaImagem.css("transform", "translateX(100%)");

  setTimeout(function () {
    passadaImagem.addClass("trasicaoCarossel");
    passadaImagem.css("transform", "translateX(0%)");
    passadaImagem.attr("data-estado", "ativo");
  }, 0.2);

  passadaImagem.one("transitionend", function () {
    $('[data-estado="escondido"]').addClass("opacity-0");
  });
}

//Event Listeners
$("button.botoesSliders").click(function () {
  const botoesSliders = $(this); // Referência para o botão clicado

  // Desabilitar o botão imediatamente
  botoesSliders.css("pointer-events", "none");

  setTimeout(function () {
    botoesSliders.css("pointer-events", "auto");
  }, 500);
});
