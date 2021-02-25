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
            $table->unsignedInteger('customer_id');
            $table->date('date');
            $table->date('due_date')->nullable();
            $table->longText('invoice_items');
            $table->string('reference')->nullable();
            $table->boolean('terms_and_conditions')->default(1);
            $table->bigInteger('grand_total');
            $table->timestamps();
            $table->softDeletes();
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
