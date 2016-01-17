<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRuleablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruleables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ruleable_id')->unsigned();
            $table->string('ruleable_type');
            $table->integer('rule_id')->unsigned();
            $table->text('parameters')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ruleables');
    }
}
