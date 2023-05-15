
const modalTipo = {
    titulo: document.getElementById('tituloModalTipo'),
    inputNome: document.getElementById('criarTipoNome'),
    labelIdTipo: document.getElementById('tipoLabel'),
    btn: {
        guardar: document.getElementById('btnGuardarTipo'),
        cancelar:document.getElementById('cancelarTipo'),
    },
    clear: () => {
        modalTipo.titulo.innerText = '';
        modalTipo.inputNome.value = '';
        modalTipo.labelIdTipo.removeAttribute('tipoId');
    }
}

document.getElementById('createTipo').addEventListener('click', function () {
    modalTipo.titulo.innerText = '';
    modalTipo.titulo.innerText = 'Criar';
});

modalTipo.btn.guardar.addEventListener('click', function () {
    let tipoNome = modalTipo.inputNome;
    let tipoId;

    if (modalTipo.labelIdTipo.hasAttribute('tipoId')){
        tipoId = modalTipo.labelIdTipo.getAttribute('tipoId');
    } else {
        tipoId = null;
    }

    if (tipoNome.value !== '' && tipoNome.value !== null){
        modalTipo.btn.guardar.setAttribute('data-bs-dismiss', 'modal');
        axios.post('/tipos/save', {
            'tipo': tipoNome.value,
            'tipoId': tipoId,
        })
            .then((response) => {
                console.log(response);
                modalTipo.clear();
                window.location = window.location;
            })
            .catch((error) => {
                console.log(error);
            })
    } else {
        alert('Nome inválido');
        modalTipo.btn.guardar.removeAttribute('data-bs-dismiss');
    }
});
modalTipo.btn.cancelar.addEventListener('click', function () {
    modalTipo.clear();
});

let editarTipoBtns = document.querySelectorAll('.btedittipo');
editarTipoBtns.forEach((elemento) => {
    elemento.addEventListener('click', function (evento) {
        let id = elemento.getAttribute('id').split('_').pop();
        modalTipo.labelIdTipo.setAttribute('tipoId', id);
        modalTipo.titulo.innerText = '';
        modalTipo.titulo.innerText = 'Editar';

        axios.get(`/getTipo/${id}`, {})
            .then((response) => {
                console.log(response);

                modalTipo.inputNome.value = response.data.tipo;
            })
            .catch((error) => {
                console.log(error);
            });
    })
});

let deleteTipoBtns = document.querySelectorAll('.btdeletetipo');
deleteTipoBtns.forEach((elemento) => {
    elemento.addEventListener('click', function (evento) {
        let id = elemento.getAttribute('id').split('_').pop();

        let confirmar = confirm('Tem a certeza que quer remover este Tipo de Utilizador?\nATENÇÃO: TODAS as Associações que este Tipo tem às Questões SERÃO ELIMINADAS');
        if (confirmar){
            let linha = elemento.parentElement.parentElement;
            console.log(linha);
            axios.delete(`/tipos/delete/${id}`, {})
                .then((response) => {
                    console.log(response);
                    linha.remove();
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    });
});
