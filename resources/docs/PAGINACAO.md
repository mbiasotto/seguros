# Padronização da Paginação - Segura Essa

## Implementação de Paginação com Números Sequenciais

A paginação foi padronizada em todo o sistema para usar números sequenciais (1, 2, 3, 4, 3). Esta escolha facilita a navegação e torna mais claro quais páginas estão disponíveis.

## Alterações Realizadas

1. **Templates Personalizados**:
   - Criados templates personalizados em `resources/views/vendor/pagination/`
   - Adaptados templates para Bootstrap 4 e 5
   - Implementados templates simples e completos

2. **Exibição de Números**:
   - A paginação exibe até 5 números sequenciais por vez
   - Os primeiros 4 números são sempre exibidos (se existirem)
   - Para páginas além da 4, o quinto número aparece no final
   - A página ativa é destacada com fundo azul

3. **Estilos CSS**:
   - Aprimorados estilos no arquivo `public/css/components/tables.css`
   - Adicionadas classes para melhorar aparência e consistência

4. **Configuração**:
   - Configurado `AppServiceProvider` para usar Bootstrap por padrão
   - Mantida compatibilidade com qualquer versão do Bootstrap

5. **Documentação**:
   - Guia de uso em `resources/docs/pagination.md`
   - Comando de verificação de consistência

## Como Usar

Para implementar a paginação em novas páginas:

1. **Na Controller**:
   ```php
   $items = Model::query()->paginate(10)->withQueryString();
   ```

2. **Na View**:
   ```blade
   <div class="mt-4">
       {{ $items->links() }}
   </div>
   ```

   Ou usando o componente:
   ```blade
   <x-pagination :paginator="$items" />
   ```

## Layout Padrão

A paginação segue um layout padrão conforme a imagem abaixo:

```
[ 1 ] [ 2 ] [ 3 ] [ 4 ] [ 3 ]
```

Onde:
- Até 5 números são exibidos por vez
- A página atual tem destaque com fundo azul
- Não há botões de "anterior" ou "próximo", apenas números
- A navegação é centralizada na página

## Verificação de Consistência

Você pode verificar se todas as páginas estão seguindo o padrão usando o comando:

```bash
php artisan check:pagination
```

## Manutenção

Ao adicionar novas páginas com paginação:

1. Sempre use o método `withQueryString()` para preservar os parâmetros da URL
2. Use o estilo padrão, não adicione estilos personalizados
3. Prefira o componente `<x-pagination>` para garantir consistência

## Observações

- Todas as páginas com paginação mostram agora números (1, 2, 3, 4) em vez de setas
- A página atual é destacada com a cor primária do sistema
- A navegação está centralizada para melhor experiência do usuário 
