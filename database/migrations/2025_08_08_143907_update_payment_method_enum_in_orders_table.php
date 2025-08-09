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
        Schema::table('orders', function (Blueprint $table) {
            // Drop the existing enum column
            $table->dropColumn('payment_method');
        });

        Schema::table('orders', function (Blueprint $table) {
            // Recreate with new enum values
            $table->enum('payment_method', [
                'bank_transfer', 
                'cash_on_delivery', 
                'ewallet', 
                'credit_card',
                'manual_transfer',
                'qris'
            ])->nullable()->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop the new enum column
            $table->dropColumn('payment_method');
        });

        Schema::table('orders', function (Blueprint $table) {
            // Recreate with old enum values
            $table->enum('payment_method', [
                'bank_transfer', 
                'cash_on_delivery', 
                'ewallet', 
                'credit_card'
            ])->nullable()->after('payment_status');
        });
    }
};
