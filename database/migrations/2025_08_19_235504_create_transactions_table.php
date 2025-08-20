<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // dono da transação
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // categoria da transação
            $table->string('title'); // descrição
            $table->decimal('amount', 10, 2); // valor
            $table->enum('type', ['receita','despesa']); // espelha category.type
            $table->date('date'); // data da transação
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('transactions');
    }
};
