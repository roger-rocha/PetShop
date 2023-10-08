<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContasAReceber extends Model
{
    use HasFactory;

    protected $table = "contas_a_receber";

    protected $fillable = [
        'nome',
        'preco',
        'valor_pago',
        'tipo',
        'data_recebimento',
        'loja_id'
    ];

    public function loja(): BelongsTo
    {
        return $this->BelongsTo(Loja::class);
    }
}
