<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('m_rule', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->smallInteger('start_score')->default(25000);
            $table->smallInteger('end_score')->default(30000);
            $table->tinyInteger('uma_1')->default(0);
            $table->tinyInteger('uma_2')->default(0);
            $table->tinyInteger('uma_3')->default(0);
            $table->tinyInteger('uma_4')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('m_rule');
    }
};
