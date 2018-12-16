<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5bd8f84867102RelationshipsToAwardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('awards', function(Blueprint $table) {
            if (!Schema::hasColumn('awards', 'partner_type_id')) {
                $table->integer('partner_type_id')->unsigned()->nullable();
                $table->foreign('partner_type_id', '214395_5bd8f84674b4c')->references('id')->on('partner_types')->onDelete('cascade');
                }
                if (!Schema::hasColumn('awards', 'company_id')) {
                $table->integer('company_id')->unsigned()->nullable();
                $table->foreign('company_id', '214395_5bd8f8468d4e5')->references('id')->on('companies')->onDelete('cascade');
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
