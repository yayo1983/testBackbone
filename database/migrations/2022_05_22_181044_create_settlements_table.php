<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->id()->index();
            $table->string('name');
            $table->string('zone_type')->nullable();
            $table->string('code');
            $table->unsignedBigInteger('settlement_type');
            $table->foreign('settlement_type')->references('id')->on('settlement_types');
            $table->unsignedBigInteger('m_id');
            $table->foreign('m_id')->references('id')->on('municipalities');
            $table->unsignedBigInteger('postal_code_id');
            $table->foreign('postal_code_id')->references('id')->on('postal_codes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settlements');
    }
};
