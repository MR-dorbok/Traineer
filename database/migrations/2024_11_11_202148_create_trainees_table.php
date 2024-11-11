<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('trainees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('specialization')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('trainees');
    }
};

