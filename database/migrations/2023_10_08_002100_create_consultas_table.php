<?php

use App\Models\Loja;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consulta', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Loja::class, 'loja_id')->constrained("loja")->cascadeOnDelete();
            $table->foreignId('paciente_id')->constrained("paciente")->cascadeOnDelete();
            $table->string('nome');
            $table->dateTime('data');
            $table->longText('descricao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consulta');
    }
};
