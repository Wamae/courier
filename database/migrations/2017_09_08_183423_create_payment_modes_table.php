<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentModesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payment_modes', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('payment_mode', 30)->unique('payment_mode');
			$table->integer('status');
			$table->integer('created_by')->unsigned()->index('created_by');
			$table->timestamps();
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
		Schema::drop('payment_modes');
	}

}
