<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWaybillStatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('waybill_statuses', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('waybill_status', 30);
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
		Schema::drop('waybill_statuses');
	}

}
