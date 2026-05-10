<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emprestimo extends Model
{
    protected $fillable = [
        'estabelecimento_requerente_id',
        'estabelecimento_atendente_id',
    ];

    public function estabelecimentoRequerente()
    {
        return $this->belongsTo(Estabelecimento::class, 'estabelecimento_requerente_id');
    }

    public function estabelecimentoAtendente()
    {
        return $this->belongsTo(Estabelecimento::class, 'estabelecimento_atendente_id');
    }

    public function patrimonios()
    {
        return $this->belongsToMany(Patrimonio::class, 'emprestimo_patrimonio')
            ->withPivot('data_emprestimo', 'data_devolucao')
            ->withTimestamps();
    }
}