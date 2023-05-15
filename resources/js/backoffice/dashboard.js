const { default: axios } = require("axios");

// botao submeter do input file
let inputFile = document.getElementById('formFile');
let btnSubmitExcel = document.getElementById('btnSubmitExcel');

// Verifica se existe algum ficheiro carregado para submeter
inputFile.addEventListener('change', () => {
    if (inputFile.value != '') {
        btnSubmitExcel.style.display = "flex";
    } else {
        btnSubmitExcel.style.display = "none";
    }
})

// email
let inputEmail = document.getElementById('exampleInputEmail1')
let btnEmailUpdate = document.getElementById('alterarEmail')
let divAlerta = document.getElementById('alertSucessoCustom')

axios.get('/dashboard/getemail').then((response) => {
    let email = response.data.nome
    inputEmail.value = email
}).catch((error) => {
    console.log(error)
});

btnEmailUpdate.addEventListener('click', () => {
    let email = inputEmail.value
    axios.post('/dashboard/postemail',{
        email
    }).then((response)=>{
        if (response.data ==1){
            divAlerta.innerText = 'Email atualizado com Sucesso!'
            divAlerta.style.display= 'flex'
        }
    }).catch((error)=>{
        console.log(error)
    })
})
