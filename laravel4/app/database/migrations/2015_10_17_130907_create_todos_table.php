<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTodosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Schema::table('todos', function(Blueprint $table){});
		Schema::create('todos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->integer('status');
			$table->timestamp('completed_at')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Schema::table('todos', function(Blueprint $table){});
		Schema::dropIfExists('todos');
	}

}
