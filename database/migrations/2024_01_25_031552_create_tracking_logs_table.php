<?php

use App\Models\SalesOrder;
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
        Schema::create('tracking_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SalesOrder::class)->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('tracking_logs');
    }
};
