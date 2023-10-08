<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consulta extends Model
{
    use HasFactory;

    protected $table = 'consulta';

    protected $fillable = [
        'nome',
        'data',
        'descricao',
        'loja_id'
    ];

    public function loja(): BelongsTo
    {
        return $this->belongsTo(Loja::class);
    }
}
