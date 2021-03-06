<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationNavigationNodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('navigation_navigation_node', function($table) {
            $table->integer('navigation_id');
            $table->integer('navigation_node_id');
            $table->integer('sort_order');
            $table->integer('parent_id');
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
		Schema::drop('navigation_navigation_nodes');
	}

}
