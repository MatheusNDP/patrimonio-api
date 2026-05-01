<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estabelecimento extends Model
{
    protected $fillable = [
        'nome',
        'cnpj',
        'tipo',
        'prazo_maximo_emprestimo',
    ];

    public function patrimonios(): HasMany
    {
        return $this->hasMany(Patrimonio::class, 'estabelecimento_pai_id');
    }

    public function emprestimosComoRequerente(): HasMany
    {
        return $this->hasMany(Emprestimo::class, 'estabelecimento_requerente_id');
    }

    public function emprestimosComoAtendente(): HasMany
    {
        return $this->hasMany(Emprestimo::class, 'estabelecimento_atendente_id');
    }
}