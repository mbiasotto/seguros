# Guia de Paginação - Segura Essa

Este guia explica como implementar a paginação de forma consistente em todo o sistema.

## 1. Nas Controllers

Para paginar os resultados de consultas, use o método `paginate()`:

```php
// No método da controller
public function index(Request $request)
{
    $query = Model::query();
    
    // Aplicar filtros, se necessário
    if ($request->has('search')) {
        $query->where('nome', 'like', "%{$request->search}%");
    }
    
    // Paginar os resultados (10 itens por página)
    $items = $query->paginate(10)->withQueryString();
    
    // Passar os itens paginados para a view
    return view('module.index', compact('items'));
}
```

## 2. Nas Views

Para exibir a paginação, use o método `links()` na variável paginada:

```blade
<div class="mt-4">
    {{ $items->links() }}
</div>
```

Ou use o componente de paginação:

```blade
<x-pagination :paginator="$items" />
```

## 3. Estilo Consistente

Os estilos da paginação são definidos no arquivo `public/css/components/tables.css`. A paginação é exibida como números em vez de setas para maior clareza.

**Exemplos:**

- Página atual: `1`
- Próxima página: `2`
- Página após a próxima: `3`

## 4. Implementação em Novas Páginas

Ao criar novas páginas com paginação, sempre siga este padrão:

1. Na controller, use `->paginate(10)->withQueryString()` para preservar os parâmetros de consulta.
2. Na view, use `{{ $items->links() }}` ou o componente `<x-pagination :paginator="$items" />`.
3. Não adicione estilos personalizados para a paginação nas views individuais.

## 5. Configuração

A configuração da paginação é feita no `AppServiceProvider.php`:

```php
public function boot(): void
{
    // Configuração da paginação para usar o Bootstrap
    Paginator::useBootstrap();
}
```

Os templates de paginação estão em `resources/views/vendor/pagination/`. 
