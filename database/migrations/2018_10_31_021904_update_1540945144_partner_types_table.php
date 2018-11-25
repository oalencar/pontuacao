<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1540945144PartnerTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partner_types', function (Blueprint $table) {
            if(Schema::hasColumn('partner_types', 'company_id')) {
                $table->dropForeign('224348_5bd8f3dc69323');
                $table->dropIndex('224348_5bd8f3dc69323');
                $table->dropColumn('company_id');
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
        Schema::table('partner_types', function (Blueprint $table) {
                        
        });

    }
}
