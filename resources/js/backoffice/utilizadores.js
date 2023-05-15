const { default: axios } = require("axios");
const DataTable = require("datatables.net");
//Modal
const modalUser = {
    titulo: document.getElementById('tituloModalUser'),
    input: {
        nome: document.getElementById('criarUserNome'),
        email: document.getElementById('criarUserEmail'),
        pass: document.getElementById('criarUserPass'),
        confirm: document.getElementById('userConfirmPass'),
        tipo: document.getElementById('radios'),
    },
    labelPass: document.getElementById('labelPass'),
    labelConfirm: document.getElementById('labelConfirm'),
    labelTipo: document.getElementById('labelTipo'),
    labelIdUser: document.getElementById('userLabel'),
    warningpass: document.getElementById('warningpass'),
    btn: {
        guardar: document.getElementById('btnGuardarUser'),
        cancelar: document.getElementById('cancelarGuardarUser'),
        transferir: document.getElementById('btnTranferirUserNotAuth'),
    },
    clear: () => {
        modalUser.titulo.innerText = '';
        modalUser.input.nome.value = '';
        modalUser.input.email.value = '';
        modalUser.input.pass.value = '';
        modalUser.input.tipo.innerHTML = '';
        modalUser.labelIdUser.removeAttribute('userId');
    },
}

//Abrir Modal para criar utilizador
document.getElementById('createUserModal').addEventListener('click', function () {
    modalUser.clear();
    modalUser.titulo.innerText = '';
    modalUser.titulo.innerText = 'Criar';
    modalUser.labelPass.style.display = 'inline-block';
    modalUser.input.pass.style.display = 'block';
    modalUser.labelConfirm.style.display = 'inline-block';
    modalUser.input.confirm.style.display = 'block';
    modalUser.labelTipo.style.display = 'flex';
    modalUser.btn.guardar.style.display = 'inline-block';
    modalUser.btn.transferir.style.display = 'none';

    axios.get('/users/getTiposUser')
        .then((response) => {
            console.log(response);
            let radios = modalUser.input.tipo;
            for (let i = 0; i < response.data.length; i++) {
                radios.innerHTML += `<div class="ms-5"><input id="radio_${response.data[i].id}" name="radio" class="form-check-input radioTipo" type="radio" value="${response.data[i].id}" />
                                    <label class="form-check-label" for="radio_${response.data[i].id}">${response.data[i].tipo}</label></div>`;
            }
        })
        .catch((error) => {
            console.log(error);
        });
});

//Abrir modal para editar Utilizador
let editarUserBtns = document.querySelectorAll('.btedituser');
editarUserBtns.forEach((elemento) => {
    elemento.addEventListener('click', function (evento) {
        modalUser.clear();
        let id = elemento.getAttribute('id').split('_').pop();
        modalUser.labelIdUser.setAttribute('userId', id);
        modalUser.titulo.innerText = '';
        modalUser.titulo.innerText = 'Editar';
        modalUser.labelPass.style.display = 'inline-block';
        modalUser.input.pass.style.display = 'block';
        modalUser.labelConfirm.style.display = 'inline-block';
        modalUser.input.confirm.style.display = 'block';
        modalUser.labelTipo.style.display = 'flex';
        modalUser.btn.guardar.style.display = 'inline-block';
        modalUser.btn.transferir.style.display = 'none';

        axios.get(`/getuser/${id}`, {})
            .then((response) => {
                console.log(response.data);
                modalUser.input.nome.value = response.data[0];
                modalUser.input.email.value = response.data[1];

                let usertipo = response.data[2];
                let tipos = response.data[3];
                let radios = modalUser.input.tipo;
                for (let i = 0; i < tipos.length; i++) {
                    radios.innerHTML += `<div class="ms-5"><input id="radio_${tipos[i].id}" name="radio" class="form-check-input radioTipo" type="radio" value="${tipos[i].id}" />
                                    <label class="form-check-label" for="radio_${tipos[i].id}">${tipos[i].tipo}</label></div>`;
                }
                document.getElementById('radio_' + usertipo).checked = true;
            })
            .catch((error) => {
                console.log(error);
            });
    });
});

//Verifica a confirmação da password
modalUser.input.pass.addEventListener('keyup', function () {
    if (modalUser.input.pass.value !== modalUser.input.confirm.value) {
        modalUser.btn.guardar.setAttribute('disabled', '');
        modalUser.warningpass.style.display = 'block';
    } else {
        modalUser.btn.guardar.removeAttribute('disabled');
        modalUser.warningpass.style.display = 'none';
    }
});
modalUser.input.confirm.addEventListener('keyup', function () {
    if (modalUser.input.pass.value !== modalUser.input.confirm.value) {
        modalUser.btn.guardar.setAttribute('disabled', '');
        modalUser.warningpass.style.display = 'block';
    } else {
        modalUser.btn.guardar.removeAttribute('disabled');
        modalUser.warningpass.style.display = 'none';
    }
});

//MODAL UTILIZADOR NÃO AUTENTICADO
let userNotAuthBtns = document.querySelectorAll('.btnUserNotAuth');
userNotAuthBtns.forEach((elemento) => {
    elemento.addEventListener('click', function (evento) {
        modalUser.clear();
        let id = elemento.getAttribute('id').split('_').pop();
        modalUser.labelIdUser.setAttribute('userId', id);
        modalUser.titulo.innerText = '';
        modalUser.titulo.innerText = 'User Não Autenticado';
        //retirar campos desnecessários
        modalUser.labelPass.style.display = 'none';
        modalUser.input.pass.style.display = 'none';
        modalUser.labelConfirm.style.display = 'none';
        modalUser.input.confirm.style.display = 'none';
        modalUser.labelTipo.style.display = 'none';
        modalUser.btn.guardar.style.display = 'none';
        //adicionar botao
        modalUser.btn.transferir.style.display = 'inline-block';

        axios.get(`/getusernotauth/${id}`, {})
            .then((response) => {
                console.log('entrei',response.data);
                modalUser.input.nome.value = response.data[0];
                modalUser.input.email.value = response.data[1];
            })
            .catch((error) => {
                console.log(error);
            });
    });
});

//datatable para Utilizadores
$(document).ready(function () {
    $('#tableUsers').DataTable({
        searching: true,
        ordering: false,
        select: false,
        paging: true,
        pageLength: 10,
        info: false,
        lengthChange: false,
        oLanguage: {
            sSearch: "Pesquisar:"
        },
        language: {
            paginate: {
                'previous': '<i class="fa fa-arrow-left"></i>',
                'next': '<i class="fa fa-arrow-right"></i>'
            },
            emptyTable: "Não existem registos",
        },
        initComplete: function () {
            this.api()
                .columns([0, 1, 2, 3])
                .every(function (d) {
                    var column = this;
                    var theadname = $("#tableUsers th").eq([d]).text(); //used this specify table name and head
                    var select = $('<select class="form-control my-1 fw-bold"><option value="">' + theadname + '</option></select>')
                        .appendTo($(column.header()).empty())
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });

                    column
                        .data()
                        .unique()
                        .sort()
                        .each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>');
                        });
                });
        },
    });
});

//datatable para Utilizadores NÃO Autenticados
$(document).ready(function () {
    $('#tableUsersNotAuth').DataTable({
        searching: true,
        ordering: false,
        select: false,
        paging: true,
        pageLength: 10,
        info: false,
        lengthChange: false,
        oLanguage: {
            sSearch: "Pesquisar:"
        },
        language: {
            paginate: {
                'previous': '<i class="fa fa-arrow-left"></i>',
                'next': '<i class="fa fa-arrow-right"></i>'
            },
            emptyTable: "Não existem registos",
        },
        initComplete: function () {
            this.api()
                .columns([0, 1, 2, 3])
                .every(function (d) {
                    var column = this;
                    var theadname = $("#tableUsersNotAuth th").eq([d]).text(); //used this specify table name and head
                    var select = $('<select class="form-control my-1 fw-bold"><option value="">' + theadname + '</option></select>')
                        .appendTo($(column.header()).empty())
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });

                    column
                        .data()
                        .unique()
                        .sort()
                        .each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>');
                        });
                });
        },
    });
});

//Botão criar/editar (guardar) utilizador
modalUser.btn.guardar.addEventListener('click', function () {
    let username = modalUser.input.nome;
    let email = modalUser.input.email;
    let pass = modalUser.input.pass;
    let userId;

    if (modalUser.labelIdUser.hasAttribute('userId')) {
        userId = modalUser.labelIdUser.getAttribute('userId');
    } else {
        userId = null;
    }

    let tipo;
    let radios = document.querySelectorAll('.radioTipo');
    radios.forEach((elemento) => {
        if (elemento.checked) {
            tipo = elemento.getAttribute('id').split('_').pop();
        }
    });

    if (username.value !== '' && username.value !== null && email.value !== '' && email.value !== null && pass.value !== '' && pass.value !== null && tipo !== null) {
        modalUser.btn.guardar.setAttribute('data-bs-dismiss', 'modal');
        axios.post('/users/save', {
            'username': username.value,
            'email': email.value,
            'pass': pass.value,
            'tipo': tipo,
            'userId': userId,
        })
            .then((response) => {
                console.log(response);
                modalUser.clear();
                window.location = window.location;
            })
            .catch((error) => {
                console.log(error);
            });

    } else {
        alert('Dados inválidos');
        modalUser.btn.guardar.removeAttribute('data-bs-dismiss');
    }
});
modalUser.btn.cancelar.addEventListener('click', function () {
    modalUser.clear();
});

function generatePassword() {
    var length = 9,
        charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
        retVal = "";
    for (var i = 0, n = charset.length; i < length; ++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));
    }
    return retVal;
}

//Botão Criar conta para User Não Autenticado
modalUser.btn.transferir.addEventListener('click', () => {
    let username = modalUser.input.nome;
    let email = modalUser.input.email;
    let pass = '999999999';
    let tipo = 1;
    let userId = null;
    let userNotAuth = true;

    axios.post('/users/save', {
        'username': username.value,
        'email': email.value,
        'pass': pass,
        'tipo': tipo,
        'userId': userId,
        'guest': userNotAuth,
    }).then((response) => {
        console.log(response);
        modalUser.clear();
        window.location = window.location;
    }).catch((error) => {
        console.log(error);
    });
});
