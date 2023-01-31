<?php

namespace App\Http\Controllers;

use App\Models\Contas;
use App\Models\Movimentacoes;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function atualizaTabela($id)
    {
        $movimentacoes = Movimentacoes::where('conta_id', $id)->get();
        return response()->json($movimentacoes);
    }

    public function atualizaSelect($id)
    {
        $contas = Contas::where('pessoa_id', $id)->get();
        return response()->json($contas);
    }
}
