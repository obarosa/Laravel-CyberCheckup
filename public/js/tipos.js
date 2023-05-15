/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************************!*\
  !*** ./resources/js/backoffice/tipos.js ***!
  \******************************************/
var modalTipo = {
  titulo: document.getElementById('tituloModalTipo'),
  inputNome: document.getElementById('criarTipoNome'),
  labelIdTipo: document.getElementById('tipoLabel'),
  btn: {
    guardar: document.getElementById('btnGuardarTipo'),
    cancelar: document.getElementById('cancelarTipo')
  },
  clear: function clear() {
    modalTipo.titulo.innerText = '';
    modalTipo.inputNome.value = '';
    modalTipo.labelIdTipo.removeAttribute('tipoId');
  }
};
document.getElementById('createTipo').addEventListener('click', function () {
  modalTipo.titulo.innerText = '';
  modalTipo.titulo.innerText = 'Criar';
});
modalTipo.btn.guardar.addEventListener('click', function () {
  var tipoNome = modalTipo.inputNome;
  var tipoId;

  if (modalTipo.labelIdTipo.hasAttribute('tipoId')) {
    tipoId = modalTipo.labelIdTipo.getAttribute('tipoId');
  } else {
    tipoId = null;
  }

  if (tipoNome.value !== '' && tipoNome.value !== null) {
    modalTipo.btn.guardar.setAttribute('data-bs-dismiss', 'modal');
    axios.post('/tipos/save', {
      'tipo': tipoNome.value,
      'tipoId': tipoId
    }).then(function (response) {
      console.log(response);
      modalTipo.clear();
      window.location = window.location;
    })["catch"](function (error) {
      console.log(error);
    });
  } else {
    alert('Nome inválido');
    modalTipo.btn.guardar.removeAttribute('data-bs-dismiss');
  }
});
modalTipo.btn.cancelar.addEventListener('click', function () {
  modalTipo.clear();
});
var editarTipoBtns = document.querySelectorAll('.btedittipo');
editarTipoBtns.forEach(function (elemento) {
  elemento.addEventListener('click', function (evento) {
    var id = elemento.getAttribute('id').split('_').pop();
    modalTipo.labelIdTipo.setAttribute('tipoId', id);
    modalTipo.titulo.innerText = '';
    modalTipo.titulo.innerText = 'Editar';
    axios.get("/getTipo/".concat(id), {}).then(function (response) {
      console.log(response);
      modalTipo.inputNome.value = response.data.tipo;
    })["catch"](function (error) {
      console.log(error);
    });
  });
});
var deleteTipoBtns = document.querySelectorAll('.btdeletetipo');
deleteTipoBtns.forEach(function (elemento) {
  elemento.addEventListener('click', function (evento) {
    var id = elemento.getAttribute('id').split('_').pop();
    var confirmar = confirm('Tem a certeza que quer remover este Tipo de Utilizador?\nATENÇÃO: TODAS as Associações que este Tipo tem às Questões SERÃO ELIMINADAS');

    if (confirmar) {
      var linha = elemento.parentElement.parentElement;
      console.log(linha);
      axios["delete"]("/tipos/delete/".concat(id), {}).then(function (response) {
        console.log(response);
        linha.remove();
      })["catch"](function (error) {
        console.log(error);
      });
    }
  });
});
/******/ })()
;