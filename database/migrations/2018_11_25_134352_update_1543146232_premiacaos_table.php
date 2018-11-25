<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1543146232PremiacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('premiacaos', function (Blueprint $table) {
            
if (!Schema::hasColumn('premiacaos', 'title')) {
                $table->string('title')->nullable();
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
        Schema::table('premiacaos', function (Blueprint $table) {
            $table->dropColumn('title');
            
        });

    }
}
