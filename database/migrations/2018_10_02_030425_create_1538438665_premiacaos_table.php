<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1538438665PremiacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('premiacaos')) {
            Schema::create('premiacaos', function (Blueprint $table) {
                $table->increments('id');
                $table->text('description')->nullable();
                $table->integer('goal')->nullable()->unsigned();
                $table->date('start_date')->nullable();
                $table->date('finish_date')->nullable();
                $table->string('image')->nullable();
                
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
        Schema::dropIfExists('premiacaos');
    }
}
