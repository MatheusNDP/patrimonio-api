<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patrimonio extends Model
{
    protected $fillable = [
        'nome',
        'codigo',
        'tipo',
        'data_entrada',
        'estabelecimento_pai_id',
        'baixado',
        'data_baixa',
        'motivo_baixa',
    ];

    protected $casts = [
        'baixado' => 'boolean',
        'data_entrada' => 'date',
        'data_baixa' => 'date',
    ];

    public function estabelecimentoPai()
    {
        return $this->belongsTo(Estabelecimento::class, 'estabelecimento_pai_id');
    }
}