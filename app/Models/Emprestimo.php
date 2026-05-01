<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Emprestimo extends Model
{
    protected $fillable = [
        'estabelecimento_requerente_id',
        'estabelecimento_atendente_id',
        'data_emprestimo',
        'data_devolucao',
    ];

    protected $casts = [
        'data_emprestimo' => 'date',
        'data_devolucao' => 'date',
    ];

    public function estabelecimentoRequerente(): BelongsTo
    {
        return $this->belongsTo(Estabelecimento::class, 'estabelecimento_requerente_id');
    }

    public function estabelecimentoAtendente(): BelongsTo
    {
        return $this->belongsTo(Estabelecimento::class, 'estabelecimento_atendente_id');
    }

    public function patrimonios(): BelongsToMany
    {
        return $this->belongsToMany(Patrimonio::class, 'emprestimo_patrimonio');
    }
}