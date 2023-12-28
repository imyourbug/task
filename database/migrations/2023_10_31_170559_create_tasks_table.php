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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('id_task');
            $table->string('name')->nullable();
            $table->string('password')->nullable();
            $table->integer('cod');
            $table->string('receiver')->nullable();
            $table->string('phone_receiver')->nullable();
            $table->string('phone_otp')->nullable();
            $table->string('address')->nullable();
            $table->string('ward')->nullable();
            $table->string('district')->nullable();
            $table->string('province')->nullable();
            $table->string('link')->nullable();
            $table->string('code')->nullable();
            $table->integer('wage');
            $table->integer('status')->default(0); // 0 - doing, 1 - done
            $table->integer('is_display_otp')->default(0); // 0 - no, 1 - yes
            $table->unsignedBigInteger('user_id');
            $table->integer('id_order')->nullable();
            $table->string('otp')->nullable();
            $table->string('audio')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
