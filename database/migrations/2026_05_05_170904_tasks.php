<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create("tasks", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();
            $table->foreignId("parent_id")->nullable()->constrained("tasks")->nullOnDelete();
            $table->string("title");
            $table->text("description");
            $table->dateTime("deadline");
            $table->string("status")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("tasks", function (Blueprint $table) {
            $table->dropForeign(["parent_id"]);
            $table->dropColumn("parent_id");
        });

        Schema::dropIfExists("tasks");
    }
};
