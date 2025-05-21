/* 
Glava dokumenta
Ime datoteke: scripts.js
Namen: JavaScript funkcije za ustvarjanje in prikaz tortnega diagrama na spletni strani.
Avtor: Rene Kolednik
GitHub: SaB11F
 */

function createPieChart(chartData) {
    console.log('Chart data received:', chartData);
    if (!chartData || !chartData.labels || !chartData.data || !chartData.colors) {
        console.error('Invalid chart data:', chartData);
        return;
    }

    const ctx = document.getElementById('salesChart').getContext('2d');
    if (!ctx) {
        console.error('Canvas element #salesChart not found');
        return;
    }

    // Dinamično generiraj barve iz palete infografike
    const colors = [
        '#3b82f6', '#a855f7', '#ec4899', '#14b8a6',
        '#9333ea', '#f472b6', '#2dd4bf', '#60a5fa'
    ];
    chartData.colors = chartData.data.map((_, i) => colors[i % colors.length]);

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: chartData.labels,
            datasets: [{
                data: chartData.data,
                backgroundColor: chartData.colors,
                borderWidth: 1,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: '#ffffff'
                    }
                },
                title: {
                    display: true,
                    text: 'Porazdelitev porabe po kupcih (%)',
                    color: '#ffffff'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.raw}%`;
                        }
                    },
                    backgroundColor: '#1e3a8a',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff'
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true
            }
        }
    });
}