const DataTable = require('datatables.net');
// const Sortable = require('sortablejs');

//Modal
const modalGuardarCategoria = {
    titulo: document.getElementById('tituloModalCategoria'),
    inputNome: document.getElementById('criarCategoriaNome'),
    inputVisivel: document.getElementById('categoriaVisivel'),
    labelIdCat: document.getElementById('categoriaLabel'),
    btn: {
        guardar: document.getElementById('btnGuardarCategoria'),
        cancelar: document.getElementById('cancelarGuardarCategoria'),
    },
    clear: () => {
        modalGuardarCategoria.titulo.innerText = '';
        modalGuardarCategoria.inputNome.value = '';
        modalGuardarCategoria.inputVisivel.checked = false;
        modalGuardarCategoria.labelIdCat.removeAttribute('catId');
    },
}

// Ao carregar a página
document.addEventListener('DOMContentLoaded', function () {
    // Verifica se existem Categorias sem Questões
    let table = document.getElementById('tableCategorias');
    let linhas = table.rows.length;
    for (let i = 0; i < linhas; i++) {
        // Mostra um alerta para avisar o Utilizador
        if (table.rows[i].cells[2].innerText === '0') {
            document.getElementById('alertSemQuestoes').style.display = 'block';
        }
    }
});
$(document).ready(function () {
    $.noConflict();
    //datatable para paginação
    $('#tableCategorias').DataTable({
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
    })

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
            updateOrder(selectedData);
        }
    });

    // Atualiza a ordem de cada Categoria na BD
    function updateOrder(aData) {
        axios.post('/categorias/order', {
            allData: aData,
        }).then((response) => {
            let linhaOrdemCat = document.querySelectorAll('.linhaOrdemCat');
            let i = 1
            linhaOrdemCat.forEach((e) => {
                e.childNodes[1].innerHTML = '<i class="fa-solid fa-bars pe-grab">' + i + '</i>'
                i++
            })
        }).catch((error) => {
            console.log(error)
        });
    }
});

// Abre o Modal Quando é para Criar uma Categoria
document.getElementById('createCategoriaModal').addEventListener('click', function () {
    modalGuardarCategoria.titulo.innerText = '';
    modalGuardarCategoria.titulo.innerText = 'Criar';
    modalGuardarCategoria.inputVisivel.checked = true;
});

// Abre o Modal quando é para Editar uma Categoria
let editarCategoriaBtns = document.querySelectorAll('.bteditcat');
editarCategoriaBtns.forEach((elemento) => {
    elemento.addEventListener('click', function (evento) {
        modalGuardarCategoria.clear();
        let id = elemento.getAttribute('id').split('_').pop();
        modalGuardarCategoria.labelIdCat.setAttribute('catId', id);
        modalGuardarCategoria.titulo.innerText = '';
        modalGuardarCategoria.titulo.innerText = 'Editar';

        axios.get(`/getcategoria/${id}`, {})
            .then((response) => {
                console.log(response.data);
                modalGuardarCategoria.inputNome.value = response.data[0];
                modalGuardarCategoria.inputVisivel.checked = !!response.data[1];
            })
            .catch((error) => {
                console.log(error);
            });
    });
});

//Botão Criar ou Editar Categoria
modalGuardarCategoria.btn.guardar.addEventListener('click', function () {
    let nome = modalGuardarCategoria.inputNome;
    let categoriaId;

    //Vê se uma categoria está a ser criada ou editada a partir do id
    if (modalGuardarCategoria.labelIdCat.hasAttribute('catId')) {
        categoriaId = modalGuardarCategoria.labelIdCat.getAttribute('catId');
    } else {
        categoriaId = null;
    }

    //Verifica se a checkbox está assinalada
    let visivel = 0;
    if (modalGuardarCategoria.inputVisivel.checked) {
        visivel = 1;
    }

    if (nome.value !== '' && nome.value !== null) {
        modalGuardarCategoria.btn.guardar.setAttribute('data-bs-dismiss', 'modal');
        axios.post('/categorias/save', {
            'nome': nome.value,
            'visivel': visivel,
            'categoriaId': categoriaId,
        })
            .then((response) => {
                console.log(response);
                modalGuardarCategoria.clear();
                window.location = window.location;
            })
            .catch((error) => {
                console.log(error);
            });

    } else {
        alert('Nome inválido');
        modalGuardarCategoria.btn.guardar.removeAttribute('data-bs-dismiss');
    }
});
modalGuardarCategoria.btn.cancelar.addEventListener('click', function () {
    modalGuardarCategoria.clear();
});

// Botões para Eliminar uma Categoria
let deleteCategoriaBtns = document.querySelectorAll('.btdeletecat');
deleteCategoriaBtns.forEach((elemento) => {
    elemento.addEventListener('click', function (evento) {
        let id = elemento.getAttribute('id').split('_').pop();

        let confirmar = confirm('Tem a certeza que quer remover esta Categoria?\nATENÇÃO: TODAS as Questões e Respostas associadas SERÃO ELIMINADAS');
        if (confirmar) {
            let linha = elemento.parentElement.parentElement;
            console.log(linha);
            axios.delete(`/categorias/delete/${id}`, {})
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

