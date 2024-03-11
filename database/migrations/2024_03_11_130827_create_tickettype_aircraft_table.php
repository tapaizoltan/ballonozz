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
        Schema::create('tickettype_aircraft', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tickettype_id')->unsigned();
            $table->foreign('tickettype_id')->references('id')->on('tickettypes');
            $table->integer('aircraft_id')->unsigned();
            $table->foreign('aircraft_id')->references('id')->on('aircraft');
            //$table->primary(['tickettype_id', 'aircraft_id']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickettype_aircraft');
    }
};
