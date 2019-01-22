<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeletePartnerTypeIdFromAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('awards', function (Blueprint $table) {
            $table->dropForeign('214395_5bd8f84674b4c');
            $table->dropColumn('partner_type_id');
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
                $table->integer('partner_type_id')->unsigned()->nullable();
                $table->foreign('partner_type_id', '214395_5bd8f84674b4c')->after('deleted_at')->references('id')->on('partner_types')->onDelete('cascade');
            }
        });
    }
}
