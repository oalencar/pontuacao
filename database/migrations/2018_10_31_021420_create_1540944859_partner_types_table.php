<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1540944859PartnerTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('partner_types')) {
            Schema::create('partner_types', function (Blueprint $table) {
                $table->increments('id');
                $table->string('description')->nullable();
                
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
        Schema::dropIfExists('partner_types');
    }
}
