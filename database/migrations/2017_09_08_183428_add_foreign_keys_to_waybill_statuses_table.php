<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToWaybillStatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('waybill_statuses', function(Blueprint $table)
		{
			$table->foreign('created_by', 'waybill_statuses_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('updated_by', 'waybill_statuses_ibfk_2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('waybill_statuses', function(Blueprint $table)
		{
			$table->dropForeign('waybill_statuses_ibfk_1');
			$table->dropForeign('waybill_statuses_ibfk_2');
		});
	}

}
