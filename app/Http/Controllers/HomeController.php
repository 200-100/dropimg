<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\File;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // En esta variable almaceno todos los registros de la BD. lo cambio por paginate(), para hacer secciones
        $files = File::paginate(5);


        return view('welcome', compact('files'));
    }
}
