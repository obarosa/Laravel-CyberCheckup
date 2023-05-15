const DataTable = require("datatables.net");
//Modal
const modalGuardarResposta = {
    titulo: document.getElementById('tituloModalResposta'),
    inputNome: document.getElementById('criarRespostaNome'),
    inputPontos: document.getElementById('criarRespostaPontuacao'),
    labelIdQuest: document.getElementById('questaoLabel'),
    labelIdResp: document.getElementById('respostaLabel'),
    btn: {
        guardar: document.getElementById('btnGuardarResposta'),
        cancelar: document.getElementById('cancelarGuardarResposta'),
    },
    clear: () => {
        modalGuardarResposta.titulo.innerText = '';
        modalGuardarResposta.inputNome.innerText = '';
        if (modalGuardarResposta.inputPontos){
            modalGuardarResposta.inputPontos.value = '';
        }
        modalGuardarResposta.labelIdResp.removeAttribute('respId');
    },
}

$(document).ready(function () {
    $.noConflict();

    //datatable para paginação
    let dtable = new DataTable('#tableRespostas', {
        searching: true,
        select: false,
        paging: false,
        info: false,
        oLanguage: {
            "sSearch": "Pesquisar:"
        },
        lengthChange: false,
        language: {
            'paginate': {
                'previous': '<i class="fa fa-arrow-left"></i>',
                'next': '<i class="fa fa-arrow-right"></i>'
            }
        }
    });

    //datatable para ordenar cada linha da tabela
    const el = document.getElementById('row_position');
    var sortable = Sortable.create(el, {
        handle: '.fa-bars',
        animation: 150,
        onEnd: function () {
            var selectedData = new Array();
            $('#row_position>tr').each(function () {
                selectedData.push($(this).attr("id"));
            });
            console.log(selectedData);
            updateOrder(selectedData);
        }
    });

    function updateOrder(aData) {
        axios.post('/respostas/order', {
            allData: aData,
        }).then((response) => {
            let linhaOrdemResp = document.querySelectorAll('.linhaOrdemResp');
            let i = 1
            linhaOrdemResp.forEach((e) => {
                e.childNodes[1].innerHTML = '<i class="fa-solid fa-bars pe-grab">' + i + '</i>'
                i++
            })
        }).catch((error) => {
            console.log(error)
        });
    }
});

document.getElementById('createRespostaModal').addEventListener('click', function () {
    modalGuardarResposta.titulo.innerText = '';
    modalGuardarResposta.titulo.innerText = 'Criar Resposta';
});

//Criar ou editar Resposta
modalGuardarResposta.btn.guardar.addEventListener('click', function () {
    let nome = modalGuardarResposta.inputNome;
    let pontos = null;
    if (modalGuardarResposta.inputPontos){
        pontos = modalGuardarResposta.inputPontos;
        console.log(pontos);
    }
    let questaoid = modalGuardarResposta.labelIdQuest.getAttribute('questId');
    let respostaId;
    console.log();
    if (modalGuardarResposta.labelIdResp.hasAttribute('respId')) {
        respostaId = modalGuardarResposta.labelIdResp.getAttribute('respId');
    } else {
        respostaId = null;
    }
    if (nome.value !== '' && nome.value !== null) {
        if (pontos !== null){
            if (pontos.value !== '' && pontos.value !== null) {
                modalGuardarResposta.btn.guardar.setAttribute('data-bs-dismiss', 'modal');
                axios.post('/respostas/save', {
                    'respostaId': respostaId,
                    'questao': questaoid,
                    'nome': nome.value,
                    'pontos': pontos.value,
                })
                    .then((response) => {
                        console.log(response);
                        modalGuardarResposta.clear();
                        window.location = window.location;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            } else {
                alert('Pontos Inválidos')
                modalGuardarResposta.btn.guardar.removeAttribute('data-bs-dismiss');
            }
        } else {
            modalGuardarResposta.btn.guardar.setAttribute('data-bs-dismiss', 'modal');
            axios.post('/respostas/save', {
                'respostaId': respostaId,
                'questao': questaoid,
                'nome': nome.value,
                'pontos': null,
            })
                .then((response) => {
                    console.log(response);
                    modalGuardarResposta.clear();
                    window.location = window.location;
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    } else {
        alert('Nome Inválido');
        modalGuardarResposta.btn.guardar.removeAttribute('data-bs-dismiss');
    }
});

let editarRespostaBtns = document.querySelectorAll('.bteditresp');
editarRespostaBtns.forEach((elemento) => {
    elemento.addEventListener('click', function (evento) {
        console.log(elemento);
        let id = elemento.getAttribute('id').split('_').pop();
        modalGuardarResposta.labelIdResp.setAttribute('respId', id);
        modalGuardarResposta.titulo.innerText = '';
        modalGuardarResposta.titulo.innerText = 'Editar Resposta';

        let linha = elemento.parentElement.parentElement;
        if (modalGuardarResposta.inputPontos){
            modalGuardarResposta.inputPontos.value = linha.children[1].textContent;
        }
        modalGuardarResposta.inputNome.innerText = linha.children[2].textContent;
    });
});

modalGuardarResposta.btn.cancelar.addEventListener('click', function () {
    modalGuardarResposta.clear();
});

let deleteRespostaBtns = document.querySelectorAll('.btdeleteresp');
deleteRespostaBtns.forEach((elemento) => {
    elemento.addEventListener('click', function (evento) {
        let id = elemento.getAttribute('id').split('_').pop();
        let confirmar = confirm('Tem a certeza que quer remover esta Resposta?');
        if (confirmar) {
            let linha = elemento.parentElement.parentElement;
            console.log(linha);
            axios.delete(`/respostas/delete/${id}`, {})
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
