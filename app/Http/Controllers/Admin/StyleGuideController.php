<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StyleGuideController extends Controller
{
    /**
     * Exibe o guia de tipografia
     */
    public function typography()
    {
        return view('examples.typography-guide');
    }

    /**
     * Exibe exemplos de componentes
     */
    public function components()
    {
        return view('examples.components');
    }
}
