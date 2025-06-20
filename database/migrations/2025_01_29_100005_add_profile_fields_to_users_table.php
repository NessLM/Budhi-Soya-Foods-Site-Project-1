
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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->date('birth_date')->nullable()->after('phone');
            $table->enum('gender', ['male', 'female'])->nullable()->after('birth_date');
            $table->string('avatar')->nullable()->after('gender');
            $table->text('bio')->nullable()->after('avatar');
            $table->json('preferences')->nullable()->after('bio'); // For storing user preferences
            $table->timestamp('last_login_at')->nullable()->after('preferences');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'birth_date', 
                'gender',
                'avatar',
                'bio',
                'preferences',
                'last_login_at'
            ]);
        });
    }
};
