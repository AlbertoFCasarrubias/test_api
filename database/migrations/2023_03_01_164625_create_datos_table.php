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
        Schema::create('datos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country');
            $table->double('balance');
            $table->date('birthday');
            $table->string('phone');
            $table->boolean('active')->default(true);
            $table->text('address');
            $table->enum('size',['s','m', 'l', 'xl'])->default('m');
            $table->timestamps();

            $table->bigInteger('user_id')->unsigned()->default(1);
            $table->foreign('user_id')->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos');
    }
};
