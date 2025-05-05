# Organização dos Arquivos Frontend - Painel Admin

Esta documentação descreve a nova estrutura organizada dos arquivos CSS e JavaScript para o painel administrativo do sistema Segura Essa.

## Estrutura de Diretórios

```
public/
├── css/
│   ├── base/                 # Estilos base (variáveis, reset, tipografia)
│   │   ├── variables.css     # Variáveis CSS (cores, espaçamentos, etc)
│   │   ├── reset.css         # Reset CSS
│   │   ├── typography.css    # Estilos de tipografia
│   │   └── layout.css        # Layout base
│   │
│   ├── components/           # Componentes CSS reutilizáveis
│   │   ├── buttons.css       # Estilos de botões genéricos
│   │   ├── cards.css         # Cards genéricos
│   │   ├── tables.css        # Tabelas genéricas
│   │   └── ...
│   │
│   ├── admin/                # Estilos específicos do painel admin
│       ├── admin.css         # Arquivo principal que importa todos os outros
│       ├── components/       # Componentes específicos do admin
│       │   ├── buttons.css   # Botões específicos do admin
│       │   ├── cards.css     # Cards específicos do admin
│       │   └── ...
│       │
│       ├── layout/           # Layout do admin
│       │   ├── sidebar.css   # Barra lateral
│       │   ├── header.css    # Cabeçalho
│       │   ├── content.css   # Conteúdo principal
│       │   └── footer.css    # Rodapé
│       │
│       └── pages/            # Estilos específicos para cada página
│           ├── dashboard.css # Estilos da página de dashboard
│           ├── users.css     # Estilos da página de usuários
│           └── ...
│
├── js/
    ├── components/           # Componentes JS reutilizáveis
    │   ├── modals.js         # Componente de modais genéricos
    │   └── ...
    │
    ├── admin/                # JavaScript específico do painel admin
        ├── admin.js          # Arquivo principal que inicializa o sistema
        ├── components/       # Componentes JS do admin
        │   ├── sidebar.js    # Componente de barra lateral
        │   ├── modals.js     # Modais específicos do admin
        │   └── ...
        │
        └── pages/            # Scripts específicos para cada página
            ├── dashboard.js  # Script da página de dashboard
            ├── users.js      # Script da página de usuários
            └── ...
```

## Como Utilizar

### Importação de CSS

O arquivo principal `public/css/admin/admin.css` já importa todos os componentes e layouts necessários. Para utilizar em um template Blade:

```html
<!-- No head do seu layout -->
<link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
```

Para adicionar estilos específicos de uma página:

```html
<!-- No bloco @push('styles') do seu template -->
@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/pages/dashboard.css') }}">
@endpush
```

### Importação de JavaScript

O arquivo principal `public/js/admin/admin.js` já inicializa todos os componentes comuns. Os módulos específicos de cada página são carregados conforme necessário.

```html
<!-- No final do seu layout, antes de fechar o body -->
<script src="{{ asset('js/admin/admin.js') }}"></script>
```

Para adicionar scripts específicos de uma página:

```html
<!-- No bloco @push('scripts') do seu template -->
@push('scripts')
<script src="{{ asset('js/admin/pages/dashboard.js') }}"></script>
@endpush
```

## Componentes Disponíveis

### CSS

1. **Components:**
   - `buttons.css` - Estilos de botões (primário, secundário, sucesso, perigo, etc)
   - `cards.css` - Cards para exibição de conteúdo
   - `tables.css` - Tabelas para listagem de dados
   - `forms.css` - Formulários e campos de entrada
   - `alerts.css` - Alertas e notificações
   - `modals.css` - Modais e diálogos
   - `stats.css` - Cards de estatísticas para o dashboard

2. **Layout:**
   - `sidebar.css` - Barra lateral de navegação
   - `content.css` - Área de conteúdo principal

### JavaScript

1. **Components:**
   - `sidebar.js` - Comportamento da barra lateral (toggle, responsividade)
   - `modals.js` - Manipulação de modais (confirmação, exclusão, etc)

2. **Pages:**
   - `dashboard.js` - Inicialização de gráficos e estatísticas
   - `users.js` - Funcionalidades da página de usuários
   - `vendors.js` - Funcionalidades da página de vendedores
   - `establishments.js` - Funcionalidades da página de estabelecimentos
   - `documents.js` - Funcionalidades da página de documentos
   - `qrcodes.js` - Funcionalidades da página de QR Codes

## Boas Práticas

1. **Separação de Responsabilidades:**
   - Use um arquivo CSS/JS por componente ou página
   - Mantenha cada arquivo com uma única responsabilidade

2. **Nomenclatura:**
   - Use nomes descritivos para classes e IDs
   - Prefixe classes específicas do admin com `admin-`
   - Use kebab-case para classes CSS (ex: `.sidebar-toggle`)
   - Use camelCase para funções e variáveis JavaScript

3. **Otimização:**
   - Evite duplicação de código CSS e JavaScript
   - Compartilhe componentes entre páginas quando apropriado
   - Use variáveis CSS para cores, espaçamentos e tamanhos

4. **Manutenção:**
   - Atualize a documentação quando adicionar novos componentes
   - Remova código não utilizado
   - Documente o código complexo com comentários explicativos

## Diretiva @stack em Templates Blade

A diretiva `@stack` do Laravel permite que você insira conteúdo em seções específicas de um layout.

Por exemplo, no layout principal:

```html
<!DOCTYPE html>
<html>
<head>
    <!-- CSS base -->
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
    
    <!-- Estilos específicos da página -->
    @stack('styles')
</head>
<body>
    <!-- Conteúdo -->
    @yield('content')
    
    <!-- JavaScript base -->
    <script src="{{ asset('js/admin/admin.js') }}"></script>
    
    <!-- Scripts específicos da página -->
    @stack('scripts')
</body>
</html>
```

E em uma página específica:

```html
@extends('layouts.admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/pages/dashboard.css') }}">
@endpush

@section('content')
<!-- Conteúdo da página -->
@endsection

@push('scripts')
<script src="{{ asset('js/admin/pages/dashboard.js') }}"></script>
@endpush
```

---

Esta documentação foi criada para facilitar a manutenção e o desenvolvimento futuro do sistema. Siga as convenções estabelecidas para garantir um código organizado e de fácil manutenção. 
