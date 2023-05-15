const DataTable = require('datatables.net');
const bootstrap = require('bootstrap');

//Modal
const modalGuardarQuestao = {
    titulo: document.getElementById('tituloModalQuestao'),
    inputNome: document.getElementById('criarQuestaoNome'),
    inputInfo: document.getElementById('criarQuestaoInfo'),
    inputCheckObrigatoria: document.getElementById('checkObrigatoria'),
    inputCheckMultiresposta: document.getElementById('checkMultiresposta'),
    inputCheckPontuacao: document.getElementById('checkPontuacao'),
    labelIdCat: document.getElementById('categoriaLabel'),
    labelIdQuest: document.getElementById('questaoLabel'),
    tiposUser: document.getElementById('questaoTipos'),
    btn: {
        guardar: document.getElementById('btnGuardarQuestao'),
        cancelar: document.getElementById('cancelarGuardarQuestao'),
    },
    clear: () => {
        modalGuardarQuestao.titulo.innerText = '';
        modalGuardarQuestao.inputNome.innerText = '';
        modalGuardarQuestao.inputInfo.innerText = '';
        modalGuardarQuestao.labelIdQuest.removeAttribute('questId');
        modalGuardarQuestao.tiposUser.innerHTML = '';
    },
}

// tooltip para Infos e tipos de User
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
});

//Verifica se existem Questões com menos de 2 Respostas associadas
document.addEventListener('DOMContentLoaded', function () {
    let table = document.getElementById('tableQuestoes');
    let linhas = table.rows.length;
    for (let i = 0; i < linhas; i++) {
        // Mostra um alerta para avisar o Utilizador
        if (parseInt(table.rows[i].cells[2].innerText) < 2) {
            document.getElementById('alertSemRespostas').style.display = 'block';
        }
    }
});


$(document).ready(function () {
    $.noConflict();

    //datatable para paginação
    $('#tableQuestoes').DataTable({
        searching: true,
        select: false,
        paging: false,
        info: false,
        lengthChange: false,
        oLanguage: {
            "sSearch": "Pesquisar:"
        },
        columnDefs: [{
            "targets": 0,
            "orderable": false
        }],
        language: {
            'paginate': {
                'previous': '<i class="fa fa-arrow-left"></i>',
                'next': '<i class="fa fa-arrow-right"></i>'
            }
        }
    });

    //datatable para ordenar cada linha da tabela
    const el = document.getElementById('row_position');
    const sortable = Sortable.create(el, {
        handle: '.fa-bars',
        animation: 150,
        onEnd: function () {
            let selectedData = [];
            $('#row_position>tr').each(function () {
                selectedData.push($(this).attr("id"));
            });
            console.log(selectedData);
            updateOrder(selectedData);
        }
    });

    // Atualiza a ordem de cada Questão na BD
    function updateOrder(aData) {
        axios.post('/questao/order', {
            allData: aData,
        }).then((response) => {
            let linhaOrdemQuest = document.querySelectorAll('.linhaOrdemQuest');
            let i = 1
            linhaOrdemQuest.forEach((e) => {
                e.childNodes[1].innerHTML = '<i class="fa-solid fa-bars pe-grab">' + i + '</i>'
                i++
            })
        }).catch((error) => {
            console.log(error)
        });
    }
});

// Abre o Modal Quando é para Criar uma Questão
document.getElementById('createQuestaoModal').addEventListener('click', function () {
    modalGuardarQuestao.clear();
    modalGuardarQuestao.titulo.innerText = 'Criar Questão';
    let id = 'criar';
    let tiposUser = modalGuardarQuestao.tiposUser;
    modalGuardarQuestao.inputCheckPontuacao.checked = true;

    axios.get(`/questao/getTipos/${id}`, {})
        .then((response) => {
            console.log(response.data);
            let tipos = response.data[0];
            //Vai buscar todos os tipos e por cada tipo cria um botão para escolher pelo menos um
            if (tipos.length !== 0) {
                for (let i = 0; i < tipos.length; i++) {
                    if (tipos[i].id === 1) {
                        tiposUser.innerHTML +=
                            `<div class="pe-3 mt-2">
                            <input type="checkbox" class="btn-check tipouser" id=tipo_${tipos[i].id} btnCheckId="${tipos[i].id}" autocomplete="off" checked>
                            <label class="btn btn-sm btn-outline-primary" for=tipo_${tipos[i].id}>${tipos[i].tipo}</label>
                        </div>`;
                    } else {
                        tiposUser.innerHTML +=
                            `<div class="pe-3 mt-2">
                            <input type="checkbox" class="btn-check tipouser" id=tipo_${tipos[i].id} btnCheckId="${tipos[i].id}" autocomplete="off">
                            <label class="btn btn-sm btn-outline-primary" for=tipo_${tipos[i].id}>${tipos[i].tipo}</label>
                        </div>`;
                    }

                }
            }
        })
        .catch((error) => {
            console.log(error);
        });
});

// Abre o Modal quando é para Editar uma Questão
let editarQuestaoBtns = document.querySelectorAll('.bteditquest');
editarQuestaoBtns.forEach((elemento) => {
    elemento.addEventListener('click', function (evento) {
        let id = elemento.getAttribute('id').split('_').pop();
        modalGuardarQuestao.clear();
        modalGuardarQuestao.labelIdQuest.setAttribute('questId', id);
        modalGuardarQuestao.titulo.innerText = '';
        modalGuardarQuestao.titulo.innerText = 'Editar Questão';
        let tiposUser = modalGuardarQuestao.tiposUser;

        axios.get(`/getquestao/${id}`, {})
            .then((response) => {
                console.log(response.data);

                modalGuardarQuestao.inputNome.innerText = response.data[0];
                modalGuardarQuestao.inputInfo.innerText = response.data[1];
                if (response.data[2]) {
                    modalGuardarQuestao.inputCheckObrigatoria.checked = true;
                }
                if (response.data[3]) {
                    modalGuardarQuestao.inputCheckMultiresposta.checked = true;
                }
                if (response.data[4]) {
                    modalGuardarQuestao.inputCheckPontuacao.checked = true;
                }
                let tipos = response.data[5][0];
                let tiposAnteriores = response.data[5][1];

                if (tipos.length !== 0) {
                    for (let i = 0; i < tipos.length; i++) {
                        tiposUser.innerHTML +=
                            `<div class="pe-3 mt-2">
                                <input type="checkbox" class="btn-check tipouser" id=tipo_${tipos[i].id} btnCheckId="${tipos[i].id}" autocomplete="off">
                                <label class="btn btn-sm btn-outline-primary" for=tipo_${tipos[i].id}>${tipos[i].tipo}</label>
                            </div>`;
                    }
                }
                if (tiposAnteriores.length !== 0) {
                    for (let j = 0; j < tiposAnteriores.length; j++) {
                        document.querySelectorAll('.tipouser').forEach((elemento) => {
                            if (parseInt(elemento.getAttribute('btnCheckId')) === tiposAnteriores[j].id) {
                                elemento.setAttribute('checked', '');
                            }
                        });
                    }
                }

            })
            .catch((error) => {
                console.log(error);
            });

    });
});

// Botões para Eliminar uma Questão
let deleteQuestaoBtns = document.querySelectorAll('.btdeletequest');
deleteQuestaoBtns.forEach((elemento) => {
    elemento.addEventListener('click', function (evento) {
        let id = elemento.getAttribute('id').split('_').pop();

        let confirmar = confirm('Tem a certeza que quer remover esta Questão?\nATENÇÃO: TODAS as Respostas associadas SERÃO ELIMINADAS');
        if (confirmar) {
            let linha = elemento.parentElement.parentElement;
            console.log(linha);
            axios.delete(`/questoes/delete/${id}`, {})
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

//Criar ou Editar Questão
modalGuardarQuestao.btn.guardar.addEventListener('click', function () {
    let nome = modalGuardarQuestao.inputNome;
    let info = modalGuardarQuestao.inputInfo;
    let checkboxObrigatoria = modalGuardarQuestao.inputCheckObrigatoria;
    let checkboxMultiResposta = modalGuardarQuestao.inputCheckMultiresposta;
    let checkboxPontuacao = modalGuardarQuestao.inputCheckPontuacao;
    let categoriaid = modalGuardarQuestao.labelIdCat.getAttribute('catId');
    let questaoId;

    // Verifica se está a editar ou a guardar pelo ID
    if (modalGuardarQuestao.labelIdQuest.hasAttribute('questId')) {
        questaoId = modalGuardarQuestao.labelIdQuest.getAttribute('questId');
    } else {
        questaoId = null;
    }

    let obrigatoria = 0;
    if (checkboxObrigatoria.checked) {
        obrigatoria = 1;
    }
    let multiresposta = 0;
    let pontuacao = 0;
    if (checkboxMultiResposta.checked) {
        multiresposta = 1;
        pontuacao = 0;
    } else if (checkboxPontuacao.checked) {
        pontuacao = 1;
        multiresposta = 0;
    }

    let tipos = [];
    let btnsTipouser = document.querySelectorAll('.tipouser');
    btnsTipouser.forEach((elemento) => {
        if (elemento.checked) {
            tipos.push(parseInt(elemento.getAttribute('btncheckid')));
        }
    });

    console.log(tipos);

    if (nome.value !== '' && nome.value !== null && tipos.length !== 0) {
        modalGuardarQuestao.btn.guardar.setAttribute('data-bs-dismiss', 'modal');
        axios.post('/questoes/save', {
            'categoria': categoriaid,
            'questaoId': questaoId,
            'informacao': info.value,
            'obrigatoria': obrigatoria,
            'multiresposta': multiresposta,
            'pontuacao': pontuacao,
            'nome': nome.value,
            'tipos': tipos,
        })
            .then((response) => {
                console.log(response);
                modalGuardarQuestao.clear();
                window.location = window.location;
            })
            .catch((error) => {
                console.log(error);
            });
    } else {
        alert('Dados inválidos');
        modalGuardarQuestao.btn.guardar.removeAttribute('data-bs-dismiss');
    }
});
modalGuardarQuestao.btn.cancelar.addEventListener('click', function () {
    modalGuardarQuestao.clear();
});

//Impede a checkbox de Pontuação de estar selecionada caso a checkbox de MultiResposta esteja selecionada
modalGuardarQuestao.inputCheckMultiresposta.addEventListener('change', function () {
    if (this.checked){
        modalGuardarQuestao.inputCheckPontuacao.checked = false;
    }
});
//Impede a checkbox de MultiResposta de estar selecionada caso a checkbox de Pontuação esteja selecionada
modalGuardarQuestao.inputCheckPontuacao.addEventListener('change', function () {
    if (this.checked){
        modalGuardarQuestao.inputCheckMultiresposta.checked = false;
    }
});

