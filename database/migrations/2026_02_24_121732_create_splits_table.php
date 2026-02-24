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
        Schema::create('splits', function (Blueprint $table) {
            $table->id();
            $table->decimal('part',10,2)->default(0);
            $table->enum('status',['paid','unpaid'])->default('unpaid');
            $table->unsignedBigInteger('colocation_id');
            $table->foreign('colocation_id')->references('id')->on('colocations')->cascadeOnDelete();
            $table->unsignedBigInteger('debuteur_id');
            $table->foreign('debuteur_id')->references('id')->on('memberships')->cascadeOnDelete();
            $table->unsignedBigInteger('crediteur_id');
            $table->foreign('crediteur_id')->references('id')->on('memberships')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('splits');
    }
};
