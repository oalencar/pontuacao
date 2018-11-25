<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1540945846PartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partners', function (Blueprint $table) {
            if(Schema::hasColumn('partners', 'tipo')) {
                $table->dropColumn('tipo');
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
        Schema::table('partners', function (Blueprint $table) {
                        $table->enum('tipo', array('Arquiteto', 'Consultor', 'Projetista'));
                
        });

    }
}
