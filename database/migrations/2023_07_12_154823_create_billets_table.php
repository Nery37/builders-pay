<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('billets', function(Blueprint $table) {
            $table->increments('id');
			$table->string('code');
			$table->decimal('original_amount', 18, 2);
			$table->date('due_date');
			$table->date('payment_date');
			$table->decimal('interest_amount_calculated', 18, 2);
			$table->decimal('fine_amount_calculated', 18, 2);
			$table->decimal('amount', 18, 2);
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('billets');
	}
};
