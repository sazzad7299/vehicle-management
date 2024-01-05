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
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->comment('check_by')->constrained('users')->onDelete('cascade');
            $table->string('company_name');
            $table->string('mobile_no')->length(11);
            $table->text('logo')->nullable();
            $table->text('website')->nullable();
            $table->string('country')->nullable();
            $table->foreignId('division_id')->nullable()->constrained('divisions')->onDelete('cascade');
            $table->foreignId('district_id')->nullable()->constrained('districts')->onDelete('cascade');
            $table->foreignId('upazilas_id')->nullable()->constrained('upazilas')->onDelete('cascade');
            $table->foreignId('union_id')->nullable()->constrained('unions')->onDelete('cascade');
            $table->string('zip_code')->nullable();
            $table->string('street_address')->nullable();
            $table->text('google_map_location')->nullable();
            $table->text('reffer_by_name')->nullable();
            $table->string('reffer_by_phone')->nullable()->length(11);
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1=active, 2=inactive, 3=banned ');
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
        Schema::dropIfExists('pharmacies');
    }
};
