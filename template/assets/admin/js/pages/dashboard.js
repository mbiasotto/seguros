/**
 * Dashboard JavaScript
 * Template - Sistema de Gestão - By mbiasotto.com
 */

const AdminDashboard = {
    /**
     * Inicializa os componentes do dashboard
     */
    init: function() {
        // Inicializa os gráficos
        this.initCharts();

        // Inicializa a troca de tabs (Estabelecimento/Documentos)
        // This might need adjustment if the tab switching is only for the first chart
        this.setupTabSwitching();
    },

    /**
     * Inicializa os gráficos do dashboard
     */
    initCharts: function() {
        const labels = this.getMonthLabels();

        // Monthly Establishments/Documents Chart
        const $monthlyChartCanvas = $('#monthlyChart');
        if ($monthlyChartCanvas.length && typeof Chart !== 'undefined') {
            const chartData = $monthlyChartCanvas.data('chart') || {};
            this.chartData = chartData; // Store for tab switching

            const monthlyConfig = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Estabelecimentos',
                            data: chartData.establishments || this.generateRandomData(labels.length),
                            borderColor: '#1D40AE',
                            backgroundColor: 'rgba(29, 64, 174, 0.1)',
                            tension: 0.4,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true, // Keep legend for clarity with tabs
                            position: 'top'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: true, drawBorder: false }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { display: true, drawBorder: false },
                            ticks: { stepSize: 1, precision: 0 }
                        }
                    }
                }
            };
            this.monthlyChart = new Chart($monthlyChartCanvas[0], monthlyConfig);
        }

        // QR Code Logs Chart
        const $qrLogsChartCanvas = $('#qrLogsChart');
        if ($qrLogsChartCanvas.length && typeof Chart !== 'undefined') {
            // Assuming qr_logs data is passed within the same main chartData object from the controller
            const qrLogsData = ($monthlyChartCanvas.data('chart') || {}).qr_logs || this.generateRandomData(labels.length);

            const qrLogsConfig = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Acessos QR Code',
                            data: qrLogsData,
                            borderColor: 'rgba(46, 184, 92, 1)', // Green color
                            backgroundColor: 'rgba(46, 184, 92, 0.2)',
                            tension: 0.4,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: true, drawBorder: false }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { display: true, drawBorder: false },
                            ticks: { stepSize: 1, precision: 0 }
                        }
                    }
                }
            };
            this.qrLogsChart = new Chart($qrLogsChartCanvas[0], qrLogsConfig);
        }
    },

    /**
     * Configura a troca de tabs para o gráfico (Estabelecimentos/Documentos)
     */
    setupTabSwitching: function() {
        const $buttons = $('.card-header .btn-group .btn');

        if ($buttons.length) {
            $buttons.on('click', (e) => {
                // Remove a classe active de todos os botões
                $buttons.removeClass('active');

                // Adiciona a classe active ao botão clicado
                $(e.target).addClass('active');

                // Atualiza o gráfico com os dados correspondentes
                const chartType = $(e.target).data('chart-type');
                this.updateChartData(chartType);
            });
        }
    },

    /**
     * Atualiza os dados do gráfico com base no tipo selecionado
     * @param {string} type - 'establishments' ou 'documents'
     */
    updateChartData: function(type) {
        if (!this.monthlyChart || !this.chartData) return;

        let newData;

        if (type === 'documents') {
            newData = this.chartData.documents || this.generateRandomData(12);
            this.monthlyChart.data.datasets[0].label = 'Documentos';
            this.monthlyChart.data.datasets[0].borderColor = '#28a745';
            this.monthlyChart.data.datasets[0].backgroundColor = 'rgba(40, 167, 69, 0.1)';
        } else {
            newData = this.chartData.establishments || this.generateRandomData(12);
            this.monthlyChart.data.datasets[0].label = 'Estabelecimentos';
            this.monthlyChart.data.datasets[0].borderColor = '#1D40AE';
            this.monthlyChart.data.datasets[0].backgroundColor = 'rgba(29, 64, 174, 0.1)';
        }

        this.monthlyChart.data.datasets[0].data = newData;
        this.monthlyChart.update();
    },

    /**
     * Retorna os rótulos dos meses para o gráfico
     * @returns {string[]} Array com os nomes dos meses
     */
    getMonthLabels: function() {
        const months = [];
        const date = new Date();
        const monthNames = [
            'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun',
            'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'
        ];

        // Gera os últimos 12 meses a partir do mês atual
        for (let i = 11; i >= 0; i--) {
            const d = new Date(date);
            d.setMonth(d.getMonth() - i);
            const month = monthNames[d.getMonth()];
            const year = d.getFullYear().toString().substr(-2);
            months.push(`${month}/${year}`);
        }

        return months;
    },

    /**
     * Gera dados aleatórios para o gráfico (apenas para demonstração)
     * @param {number} count - Número de pontos de dados a gerar
     * @returns {number[]} Array de números inteiros
     */
    generateRandomData: function(count) {
        const data = [];

        for (let i = 0; i < count; i++) {
            data.push(Math.floor(Math.random() * 5));
        }

        return data;
    }
};

// Inicializa o dashboard quando o DOM estiver pronto (será chamado pelo admin.js)
$(document).ready(function() {
    if (typeof AdminDashboard !== 'undefined') {
        AdminDashboard.init();
    }
});

// Removed redundant global functions: initMonthlyChart, initQrLogsChart, and getMonthLabels
// All chart initialization is now handled by AdminDashboard.initCharts()
// The AdminDashboard.getMonthLabels() method is used for generating month labels.
