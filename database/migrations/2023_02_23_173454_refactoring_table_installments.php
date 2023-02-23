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

        Schema::table('installments', function (Blueprint $table) {
            $table->dropColumn('paid_amount');
            $table->string('description', 255)->after('status');
            $table->string('status')->after('debtor_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('installments', function (Blueprint $table) {
            $table->float('paid_amount');
            $table->dropColumn('description');
        });
    }
};
