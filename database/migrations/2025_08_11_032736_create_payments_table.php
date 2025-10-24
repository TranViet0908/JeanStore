<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('order_id')->index('order_id');
            $table->timestamp('payment_date')->nullable()->useCurrent();
            $table->decimal('amount', 10);
            $table->enum('method', ['cash', 'credit_card', 'bank_transfer', 'e_wallet']);
            $table->enum('status', ['pending', 'completed', 'failed'])->nullable()->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
