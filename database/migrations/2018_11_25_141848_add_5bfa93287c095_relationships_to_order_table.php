<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5bfa93287c095RelationshipsToOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function(Blueprint $table) {
            if (!Schema::hasColumn('orders', 'company_id')) {
                $table->integer('company_id')->unsigned()->nullable();
                $table->foreign('company_id', '148711_5bfa91d345f00')->references('id')->on('companies')->onDelete('cascade');
                }
                if (!Schema::hasColumn('orders', 'client_id')) {
                $table->integer('client_id')->unsigned()->nullable();
                $table->foreign('client_id', '148711_5bfa9326d4224')->references('id')->on('clientes')->onDelete('cascade');
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
        Schema::table('orders', function(Blueprint $table) {
            
        });
    }
}
