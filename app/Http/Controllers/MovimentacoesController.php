<?php

namespace App\Http\Controllers;

use App\Models\Contas;
use App\Models\Movimentacoes;
use App\Models\Pessoas;
use Exception;
use Illuminate\Http\Request;

class MovimentacoesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movimentacoes = Movimentacoes::all();
        $pessoas = Pessoas::has('contas')->get();

        return view('movimentacoes', compact('movimentacoes', 'pessoas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'pessoa_id'=> 'required',
            'conta_id'=> 'required',
            'valor' => 'required',
            'mov_tipo' => 'required'
        ],
        [
            'pessoa_id.required' => 'Escolha a pessoa',
            'conta_id.required' => 'Digite o número da conta',
            'valor.required' => 'Digite o valor',
            'mov_tipo.required' => 'Selecione o tipo da movimentação (Depósito ou Retirada)'
        ]);

        $conta = Contas::find($request->get('conta_id'));

        $valor = str_replace('.', '',$request->get('valor'));
        $valor = str_replace(',', '.', $valor);
        $valor = (float)$valor; // Transforma o input do valor em float
        $tipo = $request->get('mov_tipo');

        $saldo_conta = floatval(str_replace(',', '.', str_replace('.', '', $conta->saldo)));

        if($tipo == 1)
        {
            $valor = 0 + $valor;
            $conta->saldo = $saldo_conta + $valor; // Seta o novo saldo
        }else{
            if($saldo_conta < $valor)
            {
                throw new Exception('Saldo insuficiente');;
            }
            $valor = 0 - $valor;
            $conta->saldo = $saldo_conta + $valor; // Seta o novo saldo
        }

        $conta->timestamps = false;

        $conta->save();

        $data = date("Y-m-d H:i:s");

        $movimentacao = new Movimentacoes([
            'pessoa_id' => $request->get('pessoa_id'),
            'conta_id' => $request->get('conta_id'),
            'valor' => $valor,
            'mov_tipo' => $request->get('mov_tipo'),
            'data' => $data,
        ]);
        $movimentacao->timestamps = false;

        $movimentacao->save();
        return response()->json($movimentacao);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
