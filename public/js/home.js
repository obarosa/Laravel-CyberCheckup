/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************************!*\
  !*** ./resources/js/frontoffice/home.js ***!
  \******************************************/
var checksCat = document.querySelectorAll('.btn-check');
var btnEnviarAvaliacao = document.querySelector('.buttonPerSuccess');
var iniciarDisable = document.querySelector('#iniciarDisable'); // desabilitar botão

var countChecks = checksCat.length;
checksCat.forEach(function (elemento) {
  elemento.addEventListener('change', function () {
    if (elemento.checked) {
      countChecks += 1;
    } else {
      countChecks -= 1;
    }

    if (countChecks == 0) {
      btnEnviarAvaliacao.classList.add("disabled");
      iniciarDisable.classList.add("disabledBtn");
    } else {
      btnEnviarAvaliacao.classList.remove("disabled");
      iniciarDisable.classList.remove("disabledBtn");
    }
  });
}); // enviar Ids das Categorias para o Questionário

btnEnviarAvaliacao.addEventListener('click', function () {
  var checados = [];
  checksCat.forEach(function (elemento) {
    if (elemento.checked) {
      checados.push(elemento.getAttribute('btncheckid'));
    }
  });
  axios.get("/questoes/".concat(checados)).then(function (response) {
    console.log(response);
    window.location = response.config.url;
  })["catch"](function (error) {
    alert('Selecione pelo menos 1 categoria.');
    console.log(error);
  });
});
/******/ })()
;