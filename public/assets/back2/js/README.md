# Estrutura de JavaScript

## Organização dos Arquivos JS

A estrutura de JavaScript do projeto Segura Essa foi reorganizada para seguir boas práticas de arquitetura, evitando duplicações e melhorando a manutenção.

### Estrutura de Diretórios

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

1. Para funcionalidades globais, use `main.js`
2. Para utilitários de formulários, use `utils/form-utils.js`
3. Para adicionar novos componentes, crie um arquivo na pasta `components/`
4. Para scripts específicos de páginas, crie um arquivo na pasta `pages/`

### Boas Práticas

- Evite duplicar código entre arquivos
- Mantenha os componentes isolados e reutilizáveis
- Use namespaces para evitar conflitos de nomes
- Siga a convenção de nomenclatura existente
- Documente as funções com comentários descritivos