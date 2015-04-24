<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationNodesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_navigation_nodes', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('navigation_id')->unsigned();
            $table->integer('parent_id')->unsigned();
            $table->integer('sort_order');

            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cms_navigation_nodes');
    }

}
