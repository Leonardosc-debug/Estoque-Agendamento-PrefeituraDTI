let contadorAnexos = 1; // Contador global para os anexos

function mostrarAbaAnexos() {
    let valorSwitch = document.getElementById("flexSwitchMostrarAnexos").checked;
    let colunaEsquerda = document.querySelector("#colunaEsquerda");
    let colunaDireita = document.querySelector("#colunaDireita");
    if (valorSwitch) {
        colunaEsquerda.classList.remove("visually-hidden");
        colunaDireita.classList.add("rounded-start-0");
    }
    else {
        colunaEsquerda.classList.add("visually-hidden");
        colunaDireita.classList.remove("rounded-start-0");
    }
}

function alteradorIconeStatus() {
    let iconeStatus = document.getElementById("iconeStatus");
    let elementoStatus = document.querySelector("#selectStatus");
    if (elementoStatus.value == "pendente") {
        iconeStatus.classList = "bi bi-exclamation-circle-fill text-warning";
        elementoStatus.classList.add("focus-ring");
    }
    if (elementoStatus.value == "realizado") {
        iconeStatus.classList = "bi bi-check-circle-fill text-success";
    }
}

function validarTipoArquivo(input) {
    let arquivo = input.files[0];

    if (arquivo) {
       let tipoArquivo = arquivo.type;

       if (tipoArquivo === 'image/jpeg' || tipoArquivo === 'image/jpg' || tipoArquivo === 'image/png') {
            inserirDescEAnexo();
        } else {
            input.value = ""; // Limpa o input
            input.classList.add("is-invalid");
        }
    }  
}

function inserirDescEAnexo() {
    let grupoAnexos = document.querySelector("#grupoAnexos");

    // Cria os novos elementos
    let criarInput = document.createElement("input");
    let criarLabel = document.createElement("label");
    let criarTextArea = document.createElement("textarea");

    // Verifica qual input foi acionado
    if (contadorAnexos === 1) {
        // Adiciona o primeiro conjunto de elementos (textarea e input de outro anexo)
        criarTextArea.setAttribute("class", "form-control ms-2 mt-1 textoAnexo");
        criarTextArea.setAttribute("placeholder", "Insira o texto que acompanhará o anexo como descrição...");
        criarTextArea.setAttribute("rows", "2");
        
        // Adiciona os próximos conjuntos de elementos
        contadorAnexos = 2; // Atualiza o contador para o próximo anexo
        criarLabel.textContent = `Anexo ${contadorAnexos}:`;
        criarInput.setAttribute("class", "form-control ms-2 mt-0 mb-1");
        criarInput.setAttribute("name", "anexoArquivo");
        criarInput.setAttribute("type", "file");
        criarInput.setAttribute("onchange", "inserirDescEAnexo(this)");
        criarInput.setAttribute("accept", ".jpg, .jpeg, .png");
        //

        // Adiciona os elementos ao grupoAnexos
        grupoAnexos.appendChild(criarTextArea);
        grupoAnexos.appendChild(criarLabel);
        grupoAnexos.appendChild(criarInput);
    } else {
        if (contadorAnexos != 1) {
            criarTextArea.setAttribute("class", "form-control ms-2 textoAnexo");
            criarTextArea.setAttribute("placeholder", "Insira o texto que acompanhará o anexo como descrição...");
            criarTextArea.setAttribute("rows", "2");

            // Adiciona os próximos conjuntos de elementos
            contadorAnexos++; // Incrementa o contador para o próximo anexo
            criarLabel.textContent = `Anexo ${contadorAnexos}:`;
            criarInput.setAttribute("class", "form-control ms-2 mt-0 mb-1");
            criarInput.setAttribute("name", "anexoArquivo");
            criarInput.setAttribute("type", "file");
            criarInput.setAttribute("onchange", "inserirDescEAnexo(this)");
            criarInput.setAttribute("accept", ".jpg, .jpeg, .png");
            //

            // Adiciona os elementos ao grupoAnexos
            grupoAnexos.appendChild(criarTextArea);
            grupoAnexos.appendChild(criarLabel);
            grupoAnexos.appendChild(criarInput);
        }
    }
}