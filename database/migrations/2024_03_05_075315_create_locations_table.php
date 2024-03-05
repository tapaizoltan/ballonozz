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
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('zip_code')->nullable();
            $table->string('settlement')->nullable();
            $table->string('address')->nullable();
            $table->integer('address_area_type_id')->nullable()->comment('feltöltése másik táblából');
            $table->string('address_number')->nullable();
            $table->string('parcel_number')->nullable()->comment('helyrajzi szám');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
