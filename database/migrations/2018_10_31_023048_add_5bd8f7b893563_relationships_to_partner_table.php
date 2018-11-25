<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5bd8f7b893563RelationshipsToPartnerTable extends Migration
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
                if (!Schema::hasColumn('partners', 'partner_type_id')) {
                $table->integer('partner_type_id')->unsigned()->nullable();
                $table->foreign('partner_type_id', '148721_5bd8f7b72be0e')->references('id')->on('partner_types')->onDelete('cascade');
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
