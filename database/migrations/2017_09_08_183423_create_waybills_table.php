<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWaybillsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('waybills', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('waybill_no', 30)->nullable()->unique('waybill_no');
			$table->string('consignor', 50);
			$table->string('consignor_tel', 30);
			$table->string('consignee', 50);
			$table->string('consignee_tel', 30);
			$table->integer('origin')->index('origin');
			$table->integer('destination')->index('destination');
			$table->integer('package_type')->index('package_type');
			$table->float('quantity', 10, 0);
			$table->string('weight', 30)->nullable();
			$table->string('cbm', 30)->nullable();
			$table->string('consignor_email', 50);
			$table->text('description', 65535);
			$table->integer('payment_mode')->index('payment_mode');
			$table->float('amount_per_item', 10, 0);
			$table->float('vat', 10, 0);
			$table->float('amount', 10, 0);
			$table->integer('created_by')->unsigned()->index('created_by');
			$table->timestamps();
			$table->integer('updated_by')->unsigned()->nullable()->index('updated_by');
			$table->integer('status');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('waybills');
	}

}
