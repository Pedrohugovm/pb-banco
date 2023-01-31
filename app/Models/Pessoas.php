<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoas extends Model
{
    use HasFactory;

    protected $table = 'pessoas';

    protected $fillable = ['nome', 'cpf', 'endereco'];


    public function contas()
    {
        return $this->hasOne(Contas::class, 'pessoa_id');
    }

    public function movimentacoes()
    {
        return $this->hasMany(Movimentacoes::class, 'pessoa_id');
    }

    protected function getCpfAttribute($cpf)
    {
        $cpfcerto = substr($cpf , 0, 3).".".substr($cpf , 3, 3).".".substr($cpf , 6, 3)."-".substr($cpf , 9, 2);

        return $cpfcerto;
    }
}
