<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('credit_transfer_logs', function (Blueprint $table) {
            $table->foreignId('withdraw_transaction_id')->nullable()->constrained('transactions');
            $table->foreignId('deposit_transaction_id')->nullable()->constrained('transactions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('credit_transfer_logs', function (Blueprint $table) {
            $table->dropForeign('credit_transfer_logs_withdraw_transaction_id_foreign');
            $table->dropColumn('withdraw_transaction_id');
            $table->dropForeign('credit_transfer_logs_deposit_transaction_id_foreign');
            $table->dropColumn('deposit_transaction_id');
        });
    }
};
