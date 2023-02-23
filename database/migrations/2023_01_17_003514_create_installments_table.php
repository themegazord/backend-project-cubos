<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id');
            $table->uuid('id_billing');
            $table->date('emission_date');
            $table->date('due_date');
            $table->float('amount', 8, 2);
            $table->float('paid_amount', 8, 2);
            $table->timestamps();


            $table->foreign('users_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('installments', function (Blueprint $table) {
            $table->dropForeign('installments_users_id_foreign');
        });
        Schema::dropIfExists('installments');
    }
};
