<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToWaybillsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('waybills', function(Blueprint $table)
		{
			$table->foreign('created_by', 'waybills_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('destination', 'waybills_ibfk_2')->references('id')->on('stations')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('package_type', 'waybills_ibfk_3')->references('id')->on('package_types')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('payment_mode', 'waybills_ibfk_4')->references('id')->on('payment_modes')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('updated_by', 'waybills_ibfk_5')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('origin', 'waybills_ibfk_6')->references('id')->on('stations')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('waybills', function(Blueprint $table)
		{
			$table->dropForeign('waybills_ibfk_1');
			$table->dropForeign('waybills_ibfk_2');
			$table->dropForeign('waybills_ibfk_3');
			$table->dropForeign('waybills_ibfk_4');
			$table->dropForeign('waybills_ibfk_5');
			$table->dropForeign('waybills_ibfk_6');
		});
	}

}
