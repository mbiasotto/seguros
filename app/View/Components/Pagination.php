<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Pagination\LengthAwarePaginator;

class Pagination extends Component
{
    /**
     * O paginador que será renderizado.
     *
     * @var \Illuminate\Pagination\LengthAwarePaginator
     */
    public $paginator;

    /**
     * Criar uma nova instância do componente.
     *
     * @param  \Illuminate\Pagination\LengthAwarePaginator  $paginator
     * @return void
     */
    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * Obter a visualização / conteúdo que representa o componente.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.pagination');
    }
}
