<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('invoice_number');
            $table->string('customer_id');
            $table->string('customer_name');
            $table->string('customer_phone_number');
            $table->text('customer_address');
            $table->date('date');
            $table->date('due_date')->nullable();
            $table->longText('invoice_items');
            $table->string('reference')->nullable();
            $table->text('terms_and_conditions')->nullable();
            $table->bigInteger('grand_total');
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
        Schema::dropIfExists('invoices');
    }
}
