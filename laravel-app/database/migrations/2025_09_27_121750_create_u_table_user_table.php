<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('u_table_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('u_table_id')->constrained('u_table')->cascadeOnDelete();
            $table->foreignId('u_user_id')->constrained('u_user')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('u_table_user');
    }
};
