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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacy_id')->nullable()->constrained('pharmacies')->onDelete('cascade');
            $table->string('barcode');
            $table->string('name');
            $table->string('generic');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('manufacturer_id')->constrained('manufacturers')->onDelete('cascade');
            // $table->foreignId('strength_id')->constrained('strengths')->onDelete('cascade');
            $table->foreignId('leaf_id')->constrained('leaves')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
            $table->foreignId('type_id')->constrained('types')->onDelete('cascade');
            // $table->foreignId('shelf_number_id')->nullable()->constrained('shelf_numbers')->onDelete('cascade');
            $table->text('image')->nullable();
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
        Schema::dropIfExists('medicines');
    }
};
