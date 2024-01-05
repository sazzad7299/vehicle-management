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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacy_id')->constrained('pharmacies')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('invoice');
            $table->unique(['invoice', 'pharmacy_id']);
            $table->double('medicine_discount', 10, 2)->nullable();
            $table->tinyInteger('invoice_discount_type')->default(1)->comment('1=percent, 2=fixed');
            $table->double('invoice_discount_amount', 10, 2)->nullable();
            $table->double('subtotal', 10, 2)->nullable();
            $table->double('total', 10, 2)->nullable();
            $table->double('paid', 10, 2)->nullable();
            $table->double('due', 10, 2)->nullable();
            $table->integer('total_quantity')->default(0);
            $table->text('note')->nullable();

            $table->foreignId('created_by')->nullable()
                ->constrained('users', 'id')
                ->onDelete('set null');
            $table->foreignId('updated_by')->nullable()
                ->constrained('users', 'id')
                ->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
