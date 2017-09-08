<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMainOfficesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('main_offices', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('main_office', 50)->unique('main_office');
			$table->integer('status');
			$table->timestamps();
			$table->integer('created_by')->unsigned()->index('created_by');
			$table->integer('updated_by')->unsigned()->nullable()->index('updated_by');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('main_offices');
	}

}
