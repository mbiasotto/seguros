/**
 * Disable Tooltips JS
 *
 * Este script remove os atributos title dos botões de ação e cabeçalhos de tabela
 * para evitar o problema de exibição de tooltips não desejados quando o mouse
 * passa sobre a coluna AÇÕES.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Remover atributos title dos botões de ação
    var actionButtons = document.querySelectorAll('.action-buttons .btn');
    actionButtons.forEach(function(btn) {
        if (btn.hasAttribute('title')) {
            // Armazenar o título original em um atributo de dados
            btn.dataset.originalTitle = btn.getAttribute('title');
            // Remover o atributo title para desativar o tooltip nativo
            btn.removeAttribute('title');
        }
    });

    // Remover atributos title de todos os cabeçalhos de tabela
    var tableHeaders = document.querySelectorAll('th');
    tableHeaders.forEach(function(th) {
        if (th.hasAttribute('title')) {
            th.removeAttribute('title');
        }

        // Identificar especificamente cabeçalhos "AÇÕES"
        if (th.textContent.trim() === 'Ações' || th.textContent.trim() === 'AÇÕES') {
            // Adicionar classe específica
            th.classList.add('no-tooltip');
        }
    });
});
