<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1540944294ScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('scores')) {
            Schema::create('scores', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('score')->nullable()->unsigned();
                
                $table->timestamps();
                $table->softDeletes();

                $table->index(['deleted_at']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scores');
    }
}
