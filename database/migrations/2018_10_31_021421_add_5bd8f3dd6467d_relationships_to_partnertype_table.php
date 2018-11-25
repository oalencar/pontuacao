<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5bd8f3dd6467dRelationshipsToPartnerTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partner_types', function(Blueprint $table) {
            if (!Schema::hasColumn('partner_types', 'company_id')) {
                $table->integer('company_id')->unsigned()->nullable();
                $table->foreign('company_id', '224348_5bd8f3dc69323')->references('id')->on('companies')->onDelete('cascade');
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
        Schema::table('partner_types', function(Blueprint $table) {
            
        });
    }
}
