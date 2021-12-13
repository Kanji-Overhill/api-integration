<?php

namespace App\Http\Controllers;
use App\Models\Pagos;
use Illuminate\Http\Request;

class PagosController extends Controller
{
    public function getAllPagos(Request $request)
    {
        $pagos = Pagos::take(150)->get();
        return view('dashboard',["pagos"=>$pagos]);
    }
}
