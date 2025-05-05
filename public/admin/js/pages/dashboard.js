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
        this.setupTabSwitching();
    },

    /**
     * Inicializa os gráficos do dashboard
     */
    initCharts: function() {
        // Verifica se o Canvas existe e se Chart.js está disponível
        const $monthlyChartCanvas = $('#monthlyChart');

        if ($monthlyChartCanvas.length && typeof Chart !== 'undefined') {
            // Obtém os dados do atributo data-chart do elemento canvas
            const chartData = $monthlyChartCanvas.data('chart') || {};

            // Rótulos dos meses
            const labels = this.getMonthLabels();

            const data = {
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
            };

            const config = {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: true,
                                drawBorder: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                drawBorder: false
                            },
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            }
                        }
                    }
                }
            };

            // Cria o gráfico
            this.monthlyChart = new Chart($monthlyChartCanvas[0], config);

            // Armazena os dados do gráfico para uso posterior
            this.chartData = chartData;
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
