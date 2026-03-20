<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('restrict');
            $table->enum('type', ['expense', 'income'])->default('expense');
            $table->decimal('amount', 12, 2);
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('date');
            $table->string('payment_method')->default('Cash');
            $table->string('reference')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->enum('recurring_period', ['daily','weekly','monthly','yearly'])->nullable();
            $table->string('tags')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('expenses'); }
};
