const bootstrap = require('bootstrap');

// colocar botão submeter disponivel
let divPerguntas = document.querySelectorAll('#divPerguntas')
let submitQuestoes = document.querySelector('.submitQuestButton')
let spanSubmitQuestButton = document.querySelector('.spanSubmitQuestButton')
let obrigatorios = document.querySelectorAll('.obgt')
let multis = document.querySelectorAll('.multi')
let arrObgt = []

obrigatorios.forEach((e) => {
    arrObgt.push(e)
    e.addEventListener('change', function () {
        if (e.classList.contains('multi')) {

        } else {
            e.classList.remove('obgt');
        }
    })
});

multis.forEach((e) => {
    if (e.classList.contains('obgt')) {
        e.addEventListener('change', function () {
            let arrMultis = e.children[2].children
            let childrenArrMultis = []
            for (let j = 0; j < arrMultis.length; j++) {
                if (arrMultis[j].children[0].checked) {
                    childrenArrMultis.push(arrMultis[j].children[0])
                }
            }
            if (childrenArrMultis.length == 0) {
                e.classList.add('obgt')
                arrObgt.push(e)
            } else {
                e.classList.remove('obgt')
            }
        })
    }
})

divPerguntas.forEach((elemento) => {
    elemento.addEventListener('change', function () {
        for (let i = 0; i < arrObgt.length; i++) {
            if (!arrObgt[i].classList.contains('obgt')) {
                arrObgt.splice(i, 1);
                i--;
            }
        }
        if (arrObgt.length == 0) {
            submitQuestoes.classList.remove("disabled");
            spanSubmitQuestButton.classList.remove("disabledBtn")
        } else {
            submitQuestoes.classList.add("disabled");
            spanSubmitQuestButton.classList.add("disabledBtn")
        }
        console.log('arrObgt', arrObgt)

    })
});

// obter Ids das respostas Checadas
let respostas = document.querySelectorAll('.resposta')
let inputHidden = document.getElementById('inputHidden')

submitQuestoes.addEventListener('click', function () {
    let respostasChecked = []
    respostas.forEach((elemento) => {
        if (elemento.checked) {
            respostasChecked.push(elemento.getAttribute('value'))
        }
    });
    inputHidden.setAttribute('value', respostasChecked);


})

// tooltips - Info
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})
