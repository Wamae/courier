<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTestTablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('test_tables', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 30)->unique('name');
			$table->integer('created_by');
			$table->timestamps();
			$table->integer('updated_by')->nullable()->index('updated_by');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('test_tables');
	}

}
