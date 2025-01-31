const ctx = document.getElementById('lineChart').getContext('2d');
const myBarChart = new Chart(ctx, {
    type: 'line', // Tipo de gráfico
    data: {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'], // Etiquetas de los ejes X
        datasets: [{
            label: 'Ventas en USD', // Etiqueta del conjunto de datos
            data: [12000, 19000, 3000, 5000, 2000, 3000], // Datos
            backgroundColor: [ // Colores de las barras
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [ // Colores de los bordes
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1 // Ancho de los bordes
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true // Comienza desde cero en el eje Y
            }
        }
    }
});