/* Tratamento de filtros select */

/* Estado */
// Mostrar as opções ao focar no campo de texto
document.getElementById("selectEstado").addEventListener("focus", function () {
  document.getElementById("selectEstadoLista").style.display = "block";
});

// Ocultar as opções ao clicar fora
document.addEventListener("click", function (e) {
  if (!e.target.closest(".custom-select")) {
    document.getElementById("selectEstadoLista").style.display = "none";
  }
});

// Função de filtro para o select
function filterEstado() {
  const filter = document.getElementById("selectEstado").value.toLowerCase();
  const options = document.getElementById("selectEstadoLista").getElementsByTagName("div");

  for (let i = 0; i < options.length; i++) {
    const optionText = options[i].textContent || options[i].innerText;
    if (optionText.toLowerCase().indexOf(filter) > -1) {
      options[i].style.display = "";
    } else {
      options[i].style.display = "none";
    }
  }
}

// Selecionar um item da lista
const items = document.getElementById("selectEstadoLista").getElementsByTagName("div");
for (let i = 0; i < items.length; i++) {
  items[i].addEventListener("click", function () {
    document.getElementById("selectEstado").value = this.innerText;
    document.getElementById("selectEstadoLista").style.display = "none";
  });
}


/* Condicao */

// Mostrar as opções ao focar no campo de texto
document.getElementById("selectCondicao").addEventListener("focus", function () {
  document.getElementById("selectCondicaoLista").style.display = "block";
});

// Ocultar as opções ao clicar fora
document.addEventListener("click", function (e) {
  if (!e.target.closest(".custom-select")) {
    document.getElementById("selectCondicaoLista").style.display = "none";
  }
});

// Função de filtro para o select
function filterCondicao() {
  const filter = document.getElementById("selectCondicao").value.toLowerCase();
  const options = document.getElementById("selectCondicaoLista").getElementsByTagName("div");

  for (let i = 0; i < options.length; i++) {
    const optionText = options[i].textContent || options[i].innerText;
    if (optionText.toLowerCase().indexOf(filter) > -1) {
      options[i].style.display = "";
    } else {
      options[i].style.display = "none";
    }
  }
}

// Selecionar um item da lista
const items2 = document.getElementById("selectCondicaoLista").getElementsByTagName("div");
for (let i = 0; i < items2.length; i++) {
  items2[i].addEventListener("click", function () {
    document.getElementById("selectCondicao").value = this.innerText;
    document.getElementById("selectCondicaoLista").style.display = "none";
  });
}



/* Tabela */

// Mostrar as opções ao focar no campo de texto
document.getElementById("selectTabela").addEventListener("focus", function () {
  document.getElementById("selectTabelaLista").style.display = "block";
});

// Ocultar as opções ao clicar fora
document.addEventListener("click", function (e) {
  if (!e.target.closest(".custom-select")) {
    document.getElementById("selectTabelaLista").style.display = "none";
  }
});

// Função de filtro para o select
function filterTabela() {
  const filter = document.getElementById("selectTabela").value.toLowerCase();
  const options = document.getElementById("selectTabelaLista").getElementsByTagName("div");

  for (let i = 0; i < options.length; i++) {
    const optionText = options[i].textContent || options[i].innerText;
    if (optionText.toLowerCase().indexOf(filter) > -1) {
      options[i].style.display = "";
    } else {
      options[i].style.display = "none";
    }
  }
}

// Selecionar um item da lista
const items3 = document.getElementById("selectTabelaLista").getElementsByTagName("div");
for (let i = 0; i < items3.length; i++) {
  items3[i].addEventListener("click", function () {
    document.getElementById("selectTabela").value = this.innerText;
    document.getElementById("selectTabelaLista").style.display = "none";
  });
}





/* Classificação */

// Mostrar as opções ao focar no campo de texto
document.getElementById("selectClass").addEventListener("focus", function () {
  document.getElementById("selectClassLista").style.display = "block";
});

// Ocultar as opções ao clicar fora
document.addEventListener("click", function (e) {
  if (!e.target.closest(".custom-select")) {
    document.getElementById("selectClassLista").style.display = "none";
  }
});

// Função de filtro para o select
function filterClass() {
  const filter = document.getElementById("selectClass").value.toLowerCase();
  const options = document.getElementById("selectClassLista").getElementsByTagName("div");

  for (let i = 0; i < options.length; i++) {
    const optionText = options[i].textContent || options[i].innerText;
    if (optionText.toLowerCase().indexOf(filter) > -1) {
      options[i].style.display = "";
    } else {
      options[i].style.display = "none";
    }
  }
}

// Selecionar um item da lista
const items4 = document.getElementById("selectClassLista").getElementsByTagName("div");
for (let i = 0; i < items4.length; i++) {
  items4[i].addEventListener("click", function () {
    document.getElementById("selectClass").value = this.innerText;
    document.getElementById("selectClassLista").style.display = "none";
  });
}

/* Ação do botão voltar */
function voltar() {
  history.back();
}

