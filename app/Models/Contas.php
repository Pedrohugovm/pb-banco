<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contas extends Model
{
    use HasFactory;

    protected $table = 'contas';

    protected $fillable = ['pessoa_id', 'num_conta', 'saldo'];


    protected function getSaldoAttribute($saldo)
    {
        $saldo_certo = str_replace('.', ',', $saldo);

        return $saldo_certo;
    }
    
    public function pessoas()
    {
        return $this->belongsTo(Pessoas::class,'pessoa_id');
    }
    
    public function movimentacoes()
    {
        return $this->hasMany(Movimentacoes::class, 'conta_id');
    }
}
