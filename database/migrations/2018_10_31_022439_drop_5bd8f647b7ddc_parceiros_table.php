<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Drop5bd8f647b7ddcParceirosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('parceiros');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(! Schema::hasTable('parceiros')) {
            Schema::create('parceiros', function (Blueprint $table) {
                $table->increments('id');
                
                $table->timestamps();
                $table->softDeletes();

            $table->index(['deleted_at']);
            });
        }
    }
}
