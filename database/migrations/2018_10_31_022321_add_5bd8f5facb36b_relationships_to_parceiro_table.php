<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5bd8f5facb36bRelationshipsToParceiroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parceiros', function(Blueprint $table) {
            if (!Schema::hasColumn('parceiros', 'company_id')) {
                $table->integer('company_id')->unsigned()->nullable();
                $table->foreign('company_id', '224349_5bd8f5f944db4')->references('id')->on('companies')->onDelete('cascade');
                }
                if (!Schema::hasColumn('parceiros', 'user_id')) {
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id', '224349_5bd8f5f961a1b')->references('id')->on('users')->onDelete('cascade');
                }
                if (!Schema::hasColumn('parceiros', 'partner_id')) {
                $table->integer('partner_id')->unsigned()->nullable();
                $table->foreign('partner_id', '224349_5bd8f5f97ced3')->references('id')->on('partner_types')->onDelete('cascade');
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
        Schema::table('parceiros', function(Blueprint $table) {
            
        });
    }
}
