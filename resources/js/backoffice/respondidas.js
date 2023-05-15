import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

// Gráfico de cada Tentativa

const ctx = document.getElementById('myChart').getContext('2d');

let data = document.querySelectorAll('.resultCategoriasDisplay');

let categorias = [];
let medias = [];

data.forEach((e) => {
    let separate = e.innerText.split('\n');
    categorias.push(separate[0])
    medias.push(parseInt(separate[1]))
})

// Criar espaços no array para manter a forma de um pentágono caso não existam Categorias suficientes
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
            data: medias,
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
        plugins: {
            legend: {
                display: false
            }
        },
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
