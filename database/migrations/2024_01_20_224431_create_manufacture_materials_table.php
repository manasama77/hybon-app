<?php

use App\Models\SalesOrder;
use App\Models\Stock;
use App\Models\StockMonitor;
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
        Schema::create('manufacture_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SalesOrder::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(StockMonitor::class)->constrained()->cascadeOnDelete();
            $table->enum('metode', ['lembar', 'satuan']);
            $table->integer('qty');
            $table->decimal('panjang')->default(0);
            $table->decimal('lebar')->default(0);
            $table->decimal('price', 10, 2);
            $table->string('notes');
            $table->enum('phase_seq', [1, 2, 3, 'cutting', 'infuse', 'finishing 1', 'finishing 2', 'finishing 3'])->default(1);
            $table->integer('revisi_seq')->default(0);
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
        Schema::dropIfExists('manufacture_materials');
    }
};
