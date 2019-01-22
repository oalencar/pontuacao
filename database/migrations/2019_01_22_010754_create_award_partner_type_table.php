<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAwardPartnerTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('award_partner_type', function (Blueprint $table) {
            $table->integer('award_id')->unsigned()->nullable();
            $table->foreign('award_id')->references('id')->on('awards')->onDelete('cascade');

            $table->integer('partner_type_id')->unsigned()->nullable();
            $table->foreign('partner_type_id')->references('id')->on('partner_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('award_partner_type');
    }
}
