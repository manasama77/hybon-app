<?php

use App\Models\BarangJadi;
use App\Models\MasterBarang;
use App\Models\MetodeMolding;
use App\Models\Motif;
use App\Models\OrderFrom;
use App\Models\Stock;
use App\Models\SubMolding;
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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('code_order');
            $table->string('title');
            $table->foreignIdFor(Motif::class)->constrained()->cascadeOnDelete();
            $table->enum('metode', ['pure', 'skinning']);
            $table->integer('dp')->default(0);
            $table->integer('harga_jual')->default(0);
            $table->foreignIdFor(BarangJadi::class)->nullable()->constrained()->nullOnDelete();
            $table->string('nama_customer');
            $table->string('alamat');
            $table->string('no_telp');
            $table->foreignIdFor(OrderFrom::class)->constrained()->cascadeOnDelete();
            $table->enum('status', [
                'sales order',
                'product design',
                'manufacturing 1',
                'manufacturing 2',
                'manufacturing 3',
                'manufacturing cutting',
                'manufacturing infuse',
                'finishing 1',
                'finishing 2',
                'finishing 3',
                'rfs',
            ]);
            $table->longText('notes')->nullable();
            $table->foreignIdFor(SubMolding::class)->nullable()->constrained()->nullOnDelete();
            $table->integer('cost_molding_pure')->nullable();
            $table->decimal('panjang_skinning', 10, 2)->nullable()->default(0);
            $table->decimal('lebar_skinning', 10, 2)->nullable()->default(0);
            $table->decimal('harga_material_skinning', 10, 2)->nullable()->default(0);
            $table->foreignIdFor(Stock::class)->nullable()->constrained()->nullOnDelete();
            $table->string('photo_manufacturing_1')->nullable();
            $table->integer('revisi_manufacturing_1')->default(0);
            $table->string('photo_manufacturing_2')->nullable();
            $table->integer('revisi_manufacturing_2')->default(0);
            $table->string('photo_manufacturing_3')->nullable();
            $table->integer('revisi_manufacturing_3')->default(0);
            $table->string('photo_manufacturing_cutting')->nullable();
            $table->integer('revisi_manufacturing_cutting')->default(0);
            $table->string('photo_manufacturing_infuse')->nullable();
            $table->integer('revisi_manufacturing_infuse')->default(0);
            $table->string('photo_finishing_1')->nullable();
            $table->integer('revisi_finishing_1')->default(0);
            $table->string('photo_finishing_2')->nullable();
            $table->integer('revisi_finishing_2')->default(0);
            $table->string('photo_finishing_3')->nullable();
            $table->integer('revisi_finishing_3')->default(0);
            $table->boolean('is_lunas')->default(false);
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
        Schema::dropIfExists('sales_orders');
    }
};
