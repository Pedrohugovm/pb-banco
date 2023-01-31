<?php

namespace App\Http\Controllers;

use App\Models\Pessoas;
use Illuminate\Http\Request;

class PessoasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pessoas = Pessoas::all();
        
        return view('pessoas', compact('pessoas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome'=> 'required',
            'cpf'=> 'required',
            'endereco' => 'required'
        ],
        [
            'nome.required' => 'Digite o nome',
            'cpf.required' => 'Digite o CPF',
            'endereco.required' => 'Digite o endereço',
        ]);

        $pessoa = new Pessoas([
            'nome' => $request->get('nome'),
            'cpf' => str_replace(['.', '-'], '', $request->get('cpf')),
            'endereco' => $request->get('endereco'),
        ]);
        $pessoa->timestamps = false;

        $pessoa->save();
        return redirect('pessoas')->with('success', 'Pessoa cadastrada!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pessoas  $pessoas
     * @return \Illuminate\Http\Response
     */
    public function show(Pessoas $pessoas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pessoas  $pessoas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pessoas = Pessoas::find($id);
        return response()->json($pessoas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pessoas  $pessoas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $pessoa = Pessoas::find($request->get('pessoa_id'));

        $request->validate([
            'nome'=> 'required',
            'cpf'=> 'required',
            'endereco' => 'required',
        ],
        [
            'nome.required' => 'Digite o nome',
            'cpf.required' => 'Digite o CPF',
            'endereco.required' => 'Digite o endereço'
        ]);

        $pessoa->nome = $request->get('nome');
        $pessoa->cpf = str_replace(['.', '-'], '', $request->get('cpf'));
        $pessoa->endereco = $request->get('endereco');
        $pessoa->timestamps = false;

        $pessoa->save();

        return redirect('pessoas')->with('success', 'Pessoa atualizada!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pessoas  $pessoas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pessoa = Pessoas::with('movimentacoes', 'contas')->find($id);
        $conta = $pessoa->contas;
        $movimentacoes = $pessoa->movimentacoes;

        if($conta || $movimentacoes->first())
        {
            return redirect('pessoas')->with('error', 'Existem vínculos a esta pessoa');;
        } else{
            $pessoa->delete();
            return redirect('pessoas')->with('success', 'Pessoa deletada!');
        }        
    }
}
