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
        Schema::create('accomplishment', function (Blueprint $table) {
            $table->id();
            $table->string('tasktitle')->nullable();
            $table->text('taskdesc')->nullable();
            $table->string('tasktag')->nullable();
            $table->integer('user_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accomplishment');
    }
};
