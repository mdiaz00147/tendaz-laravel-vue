<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUpdateAtInCustomerAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_address', function (Blueprint $table) {
            $table->dropColumn('updated_at');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_address', function (Blueprint $table) {
            $table->dateTime('updated_at')->nullable();
        });
    }
}
