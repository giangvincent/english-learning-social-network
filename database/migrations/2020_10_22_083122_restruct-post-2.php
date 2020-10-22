<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RestructPost2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('delta_content');
            $table->string('type')->default('normalPost')->nullable()->change();
            $table->string('answer_list')->nullable()->change();
            $table->string('nums_pocket')->nullable()->change();
            $table->string('nums_good')->nullable()->change();
            $table->string('nums_bad')->nullable()->change();
            $table->string('nums_share')->nullable()->change();
            $table->string('nums_comment')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
