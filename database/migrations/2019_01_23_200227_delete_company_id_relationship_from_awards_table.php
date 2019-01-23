<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteCompanyIdRelationshipFromAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('awards', function (Blueprint $table) {
            $table->dropForeign('214395_5bd8f8468d4e5');
            $table->dropColumn('company_id');
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
            if(!Schema::hasColumn('partner_type_id')) {
                $table->integer('company_id')->unsigned()->nullable();
                $table->foreign('company_id', '214395_5bd8f8468d4e5')
                    ->after('deleted_at')
                    ->references('id')
                    ->on('companues')
                    ->onDelete('cascade');
            }
        });
    }
}
