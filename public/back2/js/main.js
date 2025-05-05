/**
 * Arquivo JavaScript principal
 * Segura Essa - Sistema de Gestão de Estabelecimentos
 */

// Importa os módulos
document.addEventListener('DOMContentLoaded', function() {
    // Inicializa o módulo de sidebar (menu lateral)
    initSidebar();
});

/**
 * Inicializa a funcionalidade do menu lateral responsivo
 */
function initSidebar() {
    const sidebarToggle = document.querySelector('[data-toggle="sidebar"]');
    const sidebar = document.getElementById('sidebar');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });

        // Fecha o menu ao clicar fora em dispositivos móveis
        document.addEventListener('click', function(event) {
            const isMobile = window.innerWidth < 768;
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggle = sidebarToggle.contains(event.target);

            if (isMobile && !isClickInsideSidebar && !isClickOnToggle && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
        });
    }
}

/**
 * Função para alternar a visibilidade de um elemento
 * @param {string} elementId - ID do elemento a ser alternado
 */
function toggleElement(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        if (element.style.display === 'none' || element.style.display === '') {
            element.style.display = 'block';
        } else {
            element.style.display = 'none';
        }
    }
}

/**
 * Função para mostrar uma mensagem de alerta temporária
 * @param {string} message - Mensagem a ser exibida
 * @param {string} type - Tipo de alerta (success, danger, warning, info)
 * @param {number} duration - Duração em milissegundos
 */
function showAlert(message, type = 'info', duration = 3000) {
    const alertContainer = document.getElementById('alert-container') || createAlertContainer();

    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    `;

    alertContainer.appendChild(alert);

    // Remove o alerta após a duração especificada
    setTimeout(() => {
        alert.classList.remove('show');
        setTimeout(() => alert.remove(), 150);
    }, duration);
}

/**
 * Cria um container para alertas se não existir
 * @returns {HTMLElement} Container de alertas
 */
function createAlertContainer() {
    const container = document.createElement('div');
    container.id = 'alert-container';
    container.style.position = 'fixed';
    container.style.top = '20px';
    container.style.right = '20px';
    container.style.zIndex = '9999';
    container.style.maxWidth = '350px';

    document.body.appendChild(container);
    return container;
}