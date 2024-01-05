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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacy_id')->constrained('pharmacies')->onDelete('cascade');
            $table->string('name');
            $table->string('email')->nullable();
            $table->unique(['email', 'pharmacy_id']);
            $table->string('phone')->length(11);
            $table->unique(['phone', 'pharmacy_id']);
            $table->string('company')->nullable();
            $table->string('company_phone')->nullable()->length(11);
            $table->unique(['company_phone', 'pharmacy_id']);
            $table->string('image', 255)->nullable();
            $table->text('address')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
};
