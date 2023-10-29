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
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('currency');
            $table->string('currency_key');
            $table->foreign('currency_key')
                ->references('key')
                ->on('currencies')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('currency');
            $table->dropForeign('payments_currency_key_foreign');
            $table->dropColumn('currency_key');
        });
    }
};
