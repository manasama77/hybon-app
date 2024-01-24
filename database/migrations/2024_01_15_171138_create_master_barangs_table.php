<?php

use App\Models\TipeBarang;
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
        Schema::create('master_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang');
            $table->string('nama_barang');
            $table->foreignIdFor(TipeBarang::class)->constrained()->onDelete('cascade');
            $table->string('nama_vendor');
            $table->enum('tipe_stock', ['satuan', 'lembar']);
            $table->string('satuan');
            $table->string('harga_jual');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_barangs');
    }
};
