let checksCat = document.querySelectorAll('.btn-check');
let btnEnviarAvaliacao = document.querySelector('.buttonPerSuccess');
let iniciarDisable = document.querySelector('#iniciarDisable');

// desabilitar botão
var countChecks = checksCat.length
checksCat.forEach((elemento) => {
    elemento.addEventListener('change', function () {
        if (elemento.checked) {
            countChecks += 1
        } else {
            countChecks -= 1
        }
        if (countChecks == 0) {
            btnEnviarAvaliacao.classList.add("disabled");
            iniciarDisable.classList.add("disabledBtn");
        } else {
            btnEnviarAvaliacao.classList.remove("disabled");
            iniciarDisable.classList.remove("disabledBtn");
        }
    })
})

// enviar Ids das Categorias para o Questionário
btnEnviarAvaliacao.addEventListener('click', function () {
    let checados = [];
    checksCat.forEach((elemento) => {
        if (elemento.checked) {
            checados.push(elemento.getAttribute('btncheckid'))
        }
    });
    axios.get(`/questoes/${checados}`)
        .then((response) => {
            console.log(response)
            window.location = response.config.url
        }).catch((error) => {
            alert('Selecione pelo menos 1 categoria.')
            console.log(error)
        })
})
