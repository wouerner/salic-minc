<?php

namespace App\AvaliacaoResultados\Http\Controllers;

use Illuminate\Http\Request;

class AvaliacaoComprovanteController extends Controller
{
    public function __construct()
    {
    }

    public function get(Request $request) {


        return response()->json(['teste Avaliacao Comprovante'], 200);
    }
}

