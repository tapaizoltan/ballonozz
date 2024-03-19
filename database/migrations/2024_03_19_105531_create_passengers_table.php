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
        Schema::create('passengers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coupon_code');
            $table->string('firstname');
            $table->string('lastname');
            $table->date('date_of_birth')->comment('születési dátum');
            $table->string('id_card_number')->comment('igazolvány szám');
            $table->string('body weight')->comment('testsúly');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
};
