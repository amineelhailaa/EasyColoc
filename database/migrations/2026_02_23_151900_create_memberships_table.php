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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('colocation_id');
            $table->timestamp('left_at')->nullable();
            $table->bigInteger('balance')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('role',['owner','member'])->default('member');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('colocation_id')->references('id')->on('colocations')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'colocation_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
