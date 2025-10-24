<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_email_verified_at_to_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users','email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }
            // tuỳ chọn: nếu chưa có, thêm remember_token để "nhớ đăng nhập"
            if (!Schema::hasColumn('users','remember_token')) {
                $table->rememberToken()->after('password_hash');
            }
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users','email_verified_at')) $table->dropColumn('email_verified_at');
            if (Schema::hasColumn('users','remember_token'))   $table->dropColumn('remember_token');
        });
    }
};
