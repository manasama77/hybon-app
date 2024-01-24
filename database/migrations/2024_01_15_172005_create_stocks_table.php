<?php

use App\Models\MasterBarang;
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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang');
            $table->foreignIdFor(MasterBarang::class)->constrained()->onDelete('cascade');
            $table->enum('tipe_stock', ['satuan', 'lembar']);
            $table->decimal('panjang')->default(0);
            $table->decimal('lebar')->default(0);
            $table->decimal('qty')->default(0);
            $table->enum('status', ['in', 'out', 'repair']);
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
        Schema::dropIfExists('stocks');
    }
};
