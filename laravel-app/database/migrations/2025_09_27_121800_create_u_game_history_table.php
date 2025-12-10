<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('u_game_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('u_table_id')->constrained('u_table')->cascadeOnDelete();
            $table->foreignId('u_user_id')->constrained('u_user')->cascadeOnDelete();
            $table->smallInteger('game_no');
            $table->tinyInteger('seat')->comment('1=東, 2=南, 3=西, 4=北');
            $table->tinyInteger('rank_position'); // ✅ rank → rank_position に変更
            $table->integer('score')->default(0);
            $table->decimal('point', 5, 1)->default(0.0);
            $table->tinyInteger('mistake_count')->default(0);
            $table->dateTime('played_at')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['u_table_id']);
            $table->index(['u_user_id']);
            $table->index(['rank_position']);
        });
    }


    public function down(): void {
        Schema::dropIfExists('u_game_history');
    }
};
