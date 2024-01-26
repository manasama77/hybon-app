<?php

use App\Models\MasterBarang;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_monitors', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang');
            $table->foreignIdFor(MasterBarang::class)->constrained()->onDelete('cascade');
            $table->enum('tipe_stock', ['satuan', 'lembar']);
            $table->decimal('panjang', 10, 2)->default(0);
            $table->decimal('lebar', 10, 2)->default(0);
            $table->decimal('qty')->default(0);
            $table->decimal('harga_jual', 10, 2)->default(0);
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
        Schema::table('stock_monitors', function (Blueprint $table) {
            $table->dropForeignIdFor(MasterBarang::class);
        });
        Schema::dropIfExists('stock_monitors');
    }
};
