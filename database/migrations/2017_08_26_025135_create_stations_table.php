<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stations', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('office_name', 126)->unique('office_name');
			$table->string('office_code', 30)->unique('office_code');
			$table->string('telephone_number', 30)->unique('telephone_number');
			$table->string('currency', 11);
			$table->integer('main_office')->index('main_office');
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
		Schema::drop('stations');
	}

}
