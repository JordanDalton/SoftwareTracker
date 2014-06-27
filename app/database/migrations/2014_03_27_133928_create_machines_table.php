<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMachinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('machines', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('department_id')->default(1);
			
			$table->string('mac_address')->default('Not Specified');
			$table->string('user')->default('Not Specified');
			
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
		Schema::drop('machines');
	}

}
