<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1540945759AwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('awards', function (Blueprint $table) {
            if(Schema::hasColumn('awards', 'partner_tipe_id')) {
                $table->dropForeign('214395_5bd8f20a910a5');
                $table->dropIndex('214395_5bd8f20a910a5');
                $table->dropColumn('partner_tipe_id');
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
        Schema::table('awards', function (Blueprint $table) {

        });

    }
}
