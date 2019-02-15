<?php

namespace App\AvaliacaoResultados\Http\Controllers;

use Illuminate\Http\Request;

class ProjetosSimilaresController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request, $idpronac) {
        return response()->json(['idpronac' => 134261], 200);
    }
}
