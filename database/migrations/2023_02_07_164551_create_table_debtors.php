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
    public function up(): void
    {
        Schema::create('debtors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name', 155);
            $table->string('email', 155);
            $table->string('cpf', 11);
            $table->string('phone', 20);
            $table->string('address', 155)->nullable();
            $table->string('complement', 50)->nullable();
            $table->string('cep', 8)->nullable();
            $table->string('neighborhood', 50)->nullable();
            $table->string('city', 155)->nullable();
            $table->string('state', 2)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('installments', function (Blueprint $table) {
            $table->dropColumn('debtor');
            $table->unsignedBigInteger('debtor_id')->after('status');
            $table->foreign('debtor_id')->references('id')->on('debtors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('installments', function(Blueprint $table) {
            $table->dropForeign('installments_debtor_id_foreign');
        });
        Schema::dropIfExists('debtors');
    }
};
