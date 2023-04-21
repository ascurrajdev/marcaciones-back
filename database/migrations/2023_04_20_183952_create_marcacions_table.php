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
        Schema::create('marcacions', function (Blueprint $table) {
            $table->id();
            $table->enum("type",["in","out"]);
            $table->dateTime("datetime");
            $table->json("position");
            $table->foreignId("user_id");
            $table->time("overtime")->nullable()->default("00:00:00");
            $table->foreign("user_id")->on("users")->references("id");
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marcacions');
    }
};
