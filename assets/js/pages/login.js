const senhaRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
const emailRegex = new RegExp("^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}");

//Validação da div Login - Client Side
function validacaoLogin() {
  let valido = false;
  let atendeSenha;
  let atendeEmail;
  let elementoEmail = document.getElementById('inputLoginEmail');
  let elementoSenha = document.getElementById('inputLoginPassword');
  let cardLogin = document.getElementById("cardDoLogin");

  //Validação senha
  if (!senhaRegex.test(elementoSenha.value)) {
    elementoSenha.classList.remove("is-valid");
    elementoSenha.classList.add("is-invalid");
    atendeSenha = false;
  } else {
    elementoSenha.classList.remove("is-invalid");
    elementoSenha.classList.add("is-valid");
    atendeSenha = true;
  };
  
  //Validação email 
  if (!emailRegex.test(elementoEmail.value)) {
    elementoEmail.classList.remove("is-valid");
    elementoEmail.classList.add("is-invalid");
    atendeEmail = false;
  }
  else {
    elementoEmail.classList.remove("is-invalid");
    elementoEmail.classList.add("is-valid");
    atendeEmail = true;
  };
  
  //Se for válidos, o form login será enviado. Se não for mostrará borda vermelha e não vai enviar.
  if (atendeEmail && atendeSenha) {
    cardLogin.classList.remove("border-danger");
    cardLogin.classList.add("border-success");
    valido = true;
  } else {
    cardLogin.classList.remove("border-primary");
    cardLogin.classList.add("border-danger");
  };

  return valido;
};

//Validação do modal de Registro
function validacaoRegistro() {
  let valido = false;
  let atendeEmail;
  let atendeSenha;
  let atendeNome;
  let igual;
  let elementoEmail = document.getElementById("inputRegisterEmail");
  let elementoNome = document.getElementById("inputRegisterName");
  const elementoSenha = document.getElementById('inputRegisterPassword');
  const elementoConfirmar = document.getElementById('inputRegisterConfirmPassword');

  //Validação nome de registro
  if (elementoNome.value.length < 1 || elementoNome.value === null || elementoNome.value === undefined) {
    elementoNome.classList.remove('is-valid');
    elementoNome.classList.add('is-invalid');
    elementoNome = true;
  } else {
    elementoNome.classList.remove("is-invalid");
    elementoNome.classList.add("is-valid");
    elementoNome = false;
  };

  //Validação email de registro
  if (!emailRegex.test(elementoEmail.value)) {
    elementoEmail.classList.remove("is-valid");
    elementoEmail.classList.add("is-invalid");
    atendeEmail = false;
  } else {
    elementoEmail.classList.remove("is-invalid");
    elementoEmail.classList.add("is-valid");
    atendeEmail = true;
  };

  //Validação senha de registro
  if (!senhaRegex.test(elementoSenha.value) || elementoNome.value === null || elementoNome.value === undefined) {
    elementoSenha.classList.remove("is-valid");
    elementoSenha.classList.add("is-invalid");
    atendeSenha = false;
  } else {
    elementoSenha.classList.remove("is-invalid");
    elementoSenha.classList.add("is-valid");
    atendeSenha = true;
  };

  //Validação de confirmar a senha do registro
  if (elementoConfirmar.value == null || elementoConfirmar.value != elementoSenha.value) {
    elementoConfirmar.classList.remove("is-valid");
    elementoConfirmar.classList.add("is-invalid");
    igual = false;
  } else {
    elementoConfirmar.classList.remove("is-invalid");
    elementoConfirmar.classList.add("is-valid");
    igual = true;
  };

  //Se for válidos, o form registro será enviado.
  if (atendeNome && atendeEmail && atendeSenha && igual) {
    valido = true;
  }

  return valido;
};

function vericarCondicaoRegistro() {
  const elementoSenha = document.getElementById('inputRegisterPassword');
  const spanRegisterPassword = document.getElementById('spanRegisterPassword');

  if (elementoSenha.value == null || !senhaRegex.test(elementoSenha.value)) {
    spanRegisterPassword.classList.add("text-danger");
    spanRegisterPassword.textContent = `A Senha precisa conter pelo menos 8 caracteres, uma letra maiúscula, uma letra minúscula, um número e um caractere especial.`;
  }
  else {
    spanRegisterPassword.setAttribute("class", "form-text text-success");
    spanRegisterPassword.textContent = `A Senha contém pelo menos 8 caracteres, uma letra maiúscula, uma letra minúscula, um número e um caractere especial. A condição foi atendida!`;
  };
};

function validarEsqueci() {
  let valido = false;
  let elementoEmail = document.getElementById("inputForgetEmail");

  //Validação email para esqueci senha
  if (!emailRegex.test(elementoEmail.value)) {
    elementoEmail.classList.remove("is-valid");
    elementoEmail.classList.add("is-invalid");
    valido = false;
  } else {
    elementoEmail.classList.remove("is-invalid");
    elementoEmail.classList.add("is-valid");
    valido = true;
  };

  return valido;
};

function revelarSenha(btnEye) {
    let campoSenha = document.querySelector("#" + btnEye.dataset.id);

    campoSenha.setAttribute("type", "text");
};
function ocultarSenha(btnEye) {
    let campoSenha = document.querySelector("#" + btnEye.dataset.id);
    
    campoSenha.setAttribute("type", "password");
};

