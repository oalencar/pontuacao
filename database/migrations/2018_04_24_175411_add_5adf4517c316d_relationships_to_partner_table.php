<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5adf4517c316dRelationshipsToPartnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partners', function(Blueprint $table) {
                if (!Schema::hasColumn('partners', 'company_id')) {
                    $table->integer('company_id')->unsigned()->nullable();
                    $table->foreign('company_id', '148721_5adf4514c1ebf')->references('id')->on('companies')->onDelete('cascade');
                }
                if (!Schema::hasColumn('partners', 'user_id')) {
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id', '148721_5adf4514ccfb5')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('partners', function(Blueprint $table) {

        });
    }
}
