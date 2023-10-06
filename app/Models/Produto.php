<?php

namespace App\Models;

use App\Models\Loja;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produto extends Model
{
    use HasFactory;

    protected $table = "produto";

    protected $fillable = [
        'nome', 
        'descricao', 
        'preco',
        'quantidade',
        'loja_id'
    ];

    public function loja(): BelongsTo {
        return $this->BelongsTo(Loja::class);
    }

}
