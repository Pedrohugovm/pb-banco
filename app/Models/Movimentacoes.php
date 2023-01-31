<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimentacoes extends Model
{
    use HasFactory;

    protected $table = 'movimentacoes';

    protected $fillable = ['pessoa_id', 'conta_id', 'valor', 'mov_tipo', 'data'];


    protected function getValorAttribute($valor)
    {
        $valor_certo = str_replace('.', ',', $valor);

        return $valor_certo;
    }

    public function contas()
    {
        return $this->belongsTo(Contas::class, 'conta_id');
    }

    public function pessoas()
    {
        return $this->belongsTo(Pessoas::class, 'pessoa_id');
    }
}
