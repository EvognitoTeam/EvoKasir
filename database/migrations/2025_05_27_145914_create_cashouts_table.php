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
        Schema::create('cashouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mitra_id');
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('mitra_id')
                ->references('id')
                ->on('mitra')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashouts');
    }
};
