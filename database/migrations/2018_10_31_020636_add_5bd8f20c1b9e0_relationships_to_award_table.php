<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5bd8f20c1b9e0RelationshipsToAwardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('awards', function(Blueprint $table) {
            if (!Schema::hasColumn('awards', 'partner_tipe_id')) {
                $table->integer('partner_tipe_id')->unsigned()->nullable();
                $table->foreign('partner_tipe_id', '214395_5bd8f20a910a5')->references('id')->on('partners')->onDelete('cascade');
                }

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('awards', function(Blueprint $table) {

        });
    }
}
