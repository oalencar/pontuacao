<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5bfa9046b8a9dRelationshipsToClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function(Blueprint $table) {
            if (!Schema::hasColumn('clientes', 'company_id')) {
                $table->integer('company_id')->unsigned()->nullable();
                $table->foreign('company_id', '214418_5bfa90454ab50')->references('id')->on('companies')->onDelete('cascade');
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
        Schema::table('clientes', function(Blueprint $table) {
            
        });
    }
}
