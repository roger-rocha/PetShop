<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paciente extends Model
{
    use HasFactory;

    protected $table = "paciente";

    protected $fillable = [
        "nome",
        "data_nascimento",
        "tipo"
    ];

    public function loja(): BelongsTo
    {
        return $this->belongsTo(Loja::class);
    }
}
