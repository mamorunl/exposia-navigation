<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMainTemplateToPagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cms_pages', function(Blueprint $table)
		{
			$table->string('main_template');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cms_pages', function(Blueprint $table)
		{
			$table->dropColumn('main_template');
		});
	}

}
