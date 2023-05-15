const bootstrap = require('bootstrap');
import axios from 'axios';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

// Gráfico dos resultados

const ctx = document.getElementById('myChart').getContext('2d');

axios.get('/resultados').then((response) => {
    // console.log(response.data)
    let categorias = response.data[0]
    let media = response.data[1];
    switch (categorias.length) {
        case 1:
            categorias.push('', '', '', '')
            break;
        case 2:
            categorias.push('', '', '')
            break;
        case 3:
            categorias.push('', '')
            break;
        case 4:
            categorias.push('')
            break;
        default:
            break;
    }
    const myChart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: categorias,
            datasets: [{
                label: 'Média de Pontos',
                data: media,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                r: {
                    angleLines: {
                        display: false
                    },
                    suggestedMin: 0,
                    suggestedMax: 3
                }
            }
        }
    });
}).catch((error) => {
    console.log(error)
});

axios.get('/isguest', {})
    .then((response) => {
        console.log(response.data);
        let colRight = document.querySelector('.bg-resultados-right');

        if (response.data !== 1) {
            colRight.style.display = 'none';
            const modalGuest = new bootstrap.Modal(document.getElementById('modalSubmeter'));
            modalGuest.show();
            const modalSubmeter = {
                inputNome: document.getElementById('guestName'),
                inputContacto: document.getElementById('guestContacto'),
                inputEmail: document.getElementById('guestEmail'),
                btnSubmeter: document.getElementById('btnGuardarResultadoGuest'),
            }
            modalSubmeter.btnSubmeter.addEventListener('click', function () {
                let nome = modalSubmeter.inputNome;
                let contacto = modalSubmeter.inputContacto;
                let email = modalSubmeter.inputEmail;

                if (nome.value !== null && contacto.value !== null && email.value !== null && nome.value !== '' && contacto.value !== '' && email.value !== '') {
                    if (contacto.value.length == 9 || contacto.value.length == 13) {
                        modalSubmeter.btnSubmeter.setAttribute('data-bs-dismiss', 'modal');
                        modalGuest.hide();
                        document.getElementById('esconder').removeAttribute('class');
                        colRight.style.display = 'block';
                        axios.post('/resultadoGuest', {
                            'nome': nome.value,
                            'contacto': contacto.value,
                            'email': email.value,
                        }).then((response) => {
                            console.log(response);
                        }).catch((error) => {
                            console.log(error);
                        });
                    } else {
                        alert('Atenção ao número de dígitos do seu contacto. O seu contacto tem ' + contacto.value.length + ' digitos!')
                    }
                } else {
                    alert('Dados inválidos');
                }
            });
        } else {
            document.getElementById('esconder').classList.remove('bghide');
        }

    })
    .catch((error) => {
        console.log(error);
    });
