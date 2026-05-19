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
        Schema::create('orders', function (Blueprint $table) {
        $table->id();
        // foreignId harus menunjuk ke tabel 'tables' yang sudah dibuat di atas
        $table->foreignId('table_id')->constrained('tables')->onDelete('cascade');
        $table->integer('guest_count')->default(1);
        $table->decimal('total_amount', 10, 2)->default(0);
        $table->string('status')->default('pending');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
