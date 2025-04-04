# Estrutura de CSS e JS

## Organização dos Arquivos CSS e JS

A estrutura de CSS e JS do projeto Segura Essa foi reorganizada para seguir boas práticas de arquitetura, evitando duplicações e melhorando a manutenção.

### Estrutura de Diretórios CSS

```
css/
├── base/           # Estilos base e reset
│   ├── layout.css  # Layout geral
│   └── reset.css   # Reset de estilos
├── components/     # Componentes reutilizáveis
│   ├── alerts.css
│   ├── buttons.css
│   ├── cards.css
│   ├── data-list.css
│   ├── empty-state.css
│   ├── forms.css
│   └── tables.css
├── pages/          # Estilos específicos de páginas
├── admin.css       # Estilos específicos do painel admin
├── vendor.css      # Estilos específicos do painel vendedor
├── main.css        # Arquivo principal que importa os componentes base
├── admin.main.css  # Arquivo principal para o painel admin
└── vendor.main.css # Arquivo principal para o painel vendedor
```

### Estrutura de Diretórios JS

```
js/
├── utils/          # Utilitários e funções auxiliares
│   ├── form-utils.js  # Utilitários para formulários
│   └── cep-lookup.js  # Consulta de CEP
├── components/     # Componentes JavaScript
│   ├── sidebar.js  # Funcionalidades do menu lateral
│   └── modals.js   # Funcionalidades de modais
├── pages/          # Scripts específicos de páginas
└── main.js         # Arquivo principal que inicializa os componentes
```

### Como Usar

1. Para estilos globais, use `main.css`
2. Para o painel administrativo, use `admin.main.css`
3. Para o painel do vendedor, use `vendor.main.css`
4. Para adicionar novos componentes CSS, crie um arquivo na pasta `components/`
5. Para adicionar novos utilitários JS, crie um arquivo na pasta `utils/`

### Boas Práticas

- Evite duplicar estilos e scripts entre arquivos
- Mantenha os componentes isolados e reutilizáveis
- Use variáveis CSS para cores, espaçamentos e outros valores comuns
- Siga a convenção de nomenclatura existente
- Organize os scripts em módulos com responsabilidades bem definidas
