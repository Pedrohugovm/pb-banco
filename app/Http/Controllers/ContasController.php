<?php

namespace App\Http\Controllers;

use App\Models\Contas;
use App\Models\Pessoas;
use Exception;
use Illuminate\Http\Request;

class ContasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contas = Contas::with(['pessoas'])->get();
        $pessoas = Pessoas::all();

        return view('contas', compact('contas', 'pessoas'));
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
            'num_conta'=> 'required|unique:contas'
        ],
        [
            'pessoa_id.required' => 'Escolha a pessoa',
            'num_conta.required' => 'Digite o número da conta',
            'num_conta.unique' => 'Este valor já foi cadastrado'
        ]);

        $conta = new Contas([
            'pessoa_id' => $request->get('pessoa_id'),
            'num_conta' => $request->get('num_conta'),
            'saldo' => 0,
        ]);
        $conta->timestamps = false;

        $conta->save();

        return response()->json($conta);
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
        $contas = Contas::find($id);
        return response()->json($contas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $conta = Contas::find($request->get('conta_id'));

        $request->validate([
            'pessoa_id'=> 'required',
            'num_conta'=> 'required|unique:contas'
        ],
        [
            'pessoa_id.required' => 'Escolha a pessoa',
            'num_conta.required' => 'Digite o número da conta',
            'num_conta.unique' => 'Este valor já foi cadastrado'
        ]);

        $conta->pessoa_id = $request->get('pessoa_id');
        $conta->num_conta = $request->get('num_conta');
        $conta->timestamps = false;

        $conta->save();

        return redirect('contas')->with('success', 'Conta atualizada!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conta = Contas::with('movimentacoes')->find($id);
        if($conta->movimentacoes->count() > 0)
        {
            return redirect('contas')->with('error', 'Existem movimentações nesta conta');
        } else{
            $conta->delete();
            return redirect('contas')->with('success', 'Conta deletada!');
        }

    }
}
