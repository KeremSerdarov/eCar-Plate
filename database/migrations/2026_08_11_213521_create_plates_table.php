<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plates', function (Blueprint $table) {
            $table->id();
            $table->string('number', 4);
            $table->string('prefix', 2)->default('AB');
            $table->foreignId('region_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plate_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('car_model', 100);
            $table->decimal('price_paid', 10, 2);
            $table->timestamp('registered_at');
            $table->unique(['region_id', 'number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plates');
    }
};
