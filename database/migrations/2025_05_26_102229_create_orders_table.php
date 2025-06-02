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

            // Foreign keys
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->integer('quantity')->default(1);         // Jumlah produk yang dipesan
            $table->decimal('price', 10, 2);                 // Harga saat pemesanan
            $table->timestamp('order_date')->useCurrent();   // Tanggal/waktu order

            $table->text('alamat');                          // Alamat pengiriman
            $table->text('rincian_pemesanan');               // Detail pemesanan
            $table->boolean('pilihan_cod')->default(false);  // Pilihan COD

            $table->enum('status_order', ['selesai', 'belum_selesai'])->default('belum_selesai');

            $table->timestamps(); // created_at dan updated_at
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
