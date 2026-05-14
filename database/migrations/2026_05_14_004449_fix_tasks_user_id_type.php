<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id_tmp')->nullable()->after('deadline');
        });

        DB::statement('UPDATE `tasks` SET `user_id_tmp` = CAST(`user_id` AS UNSIGNED) WHERE `user_id` IS NOT NULL');

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('deadline');
        });

        DB::statement('UPDATE `tasks` SET `user_id` = `user_id_tmp` WHERE `user_id_tmp` IS NOT NULL');

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('user_id_tmp');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->string('user_id_tmp')->nullable()->after('deadline');
        });

        DB::statement('UPDATE `tasks` SET `user_id_tmp` = CAST(`user_id` AS CHAR) WHERE `user_id` IS NOT NULL');

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->string('user_id')->nullable()->after('deadline');
        });

        DB::statement('UPDATE `tasks` SET `user_id` = `user_id_tmp` WHERE `user_id_tmp` IS NOT NULL');

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('user_id_tmp');
        });
    }
};
