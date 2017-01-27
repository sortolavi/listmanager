<?php

use Illuminate\Database\Migrations\Migration;

class UpdateTodos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('todos', function($table){
			$table->integer('sort_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('todos', function($table){
			$table->dropColumn('sort_id');
		});
	}

}