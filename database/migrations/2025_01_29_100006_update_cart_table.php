
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
        Schema::table('cart', function (Blueprint $table) {
            $table->json('product_options')->nullable()->after('quantity'); // For storing product variants/options
            $table->text('notes')->nullable()->after('product_options');
            $table->timestamp('added_at')->nullable()->after('notes');
            
            // Add indexes for better performance
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->dropColumn(['product_options', 'notes', 'added_at']);
            $table->dropIndex(['user_id', 'created_at']);
        });
    }
};
