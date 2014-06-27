<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('programs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('publisher_id')->default(1);
			
			$table->boolean('active')->default(1);
			$table->string('name')->default('Not Specified');
			$table->string('version')->nullable();
			
			$table->timestamp('created_at');
			$table->timestamp('deleted_at')->nullable();
			$table->timestamp('updated_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('programs');
	}

}
