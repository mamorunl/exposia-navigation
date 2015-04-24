<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteNavigationIdFromNavigationNodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cms_navigation_nodes', function(Blueprint $table)
		{
			$table->dropColumn('navigation_id');
            $table->dropColumn('sort_order');
            $table->dropColumn('parent_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cms_navigation_nodes', function(Blueprint $table)
		{
			$table->integer('navigation_id');
            $table->integer('sort_order');
            $table->integer('parent_id');
		});
	}

}
