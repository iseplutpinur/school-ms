<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_districts', function (Blueprint $table) {
            $table->char('id', 7)->primary();
            $table->char('regency_id', 4)->nullable();
            $table->string('name');
            $table->timestamps();
            $table->foreign('regency_id')
                ->references('id')->on('address_regencies')
                // ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address_districts');
    }
}
