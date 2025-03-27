<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('site.index');
    }

    /**
     * Display the partner page.
     *
     * @return \Illuminate\View\View
     */
    public function parceiro()
    {
        return view('site.parceiro');
    }

    /**
     * Display the vendor page.
     *
     * @return \Illuminate\View\View
     */
    public function vendedor()
    {
        return view('site.vendedor');
    }
}