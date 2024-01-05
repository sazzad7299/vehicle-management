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
        Schema::create('cash_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacy_id')->constrained('pharmacies')->onDelete('cascade');
            $table->string('model_type');
            $table->bigInteger('model_id');
            $table->tinyInteger('status')->default(1)->comment('1=active, 2=inactive');
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
        Schema::dropIfExists('cash_histories');
    }
};
