<?php

namespace App\AvaliacaoResultados\Http\Controllers;

use Illuminate\Http\Request;

class DiligenciaController extends Controller
{
    public function __construct()
    {
    }

    public function get(Request $request) {


        return response()->json(['teste Diligencia Controller'], 200);
    }
}
