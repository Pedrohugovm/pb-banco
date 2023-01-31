<?php

namespace App\Http\Controllers;

use App\Models\Contas;
use App\Models\Movimentacoes;
use App\Models\Pessoas;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $todas_contas = Contas::all();
        $pessoas = Pessoas::all()->count();
        $contas = Contas::all()->count();
        $movimentacoes = Movimentacoes::all()->count();

        $saldo_total = 0;
        foreach($todas_contas as $conta)
        {
            $saldo_conta = floatval(str_replace(',', '.', str_replace('.', '', $conta->saldo)));
            $saldo_total += $saldo_conta;
        }
        
        return view('dashboard', compact('pessoas', 'contas', 'movimentacoes', 'saldo_total'));
    }
}
