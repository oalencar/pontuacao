<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5bd8f1a98daf9RelationshipsToScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scores', function(Blueprint $table) {
            if (!Schema::hasColumn('scores', 'order_id')) {
                $table->integer('order_id')->unsigned()->nullable();
                $table->foreign('order_id', '224347_5bd8f1a7f22be')->references('id')->on('orders')->onDelete('cascade');
                }
                if (!Schema::hasColumn('scores', 'user_id')) {
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id', '224347_5bd8f1a81443b')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('scores', function(Blueprint $table) {
            
        });
    }
}
