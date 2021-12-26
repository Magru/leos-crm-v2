<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->json('contacts');
            $table->json('website');
            $table->json('dev_site');
            $table->json('social');
            $table->text('domain_notes');
            $table->text('note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('contacts');
            $table->dropColumn('website');
            $table->dropColumn('dev_site');
            $table->dropColumn('social');
            $table->dropColumn('domain_notes');
            $table->dropColumn('note');
        });
    }
}
