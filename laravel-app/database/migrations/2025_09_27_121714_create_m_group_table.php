<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('m_group', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->foreignId('m_rule_id')->constrained('m_rule')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('m_group');
    }
};
