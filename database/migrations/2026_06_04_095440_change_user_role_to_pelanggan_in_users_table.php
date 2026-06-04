<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            // 1. Expand ENUM to allow both temporarily
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'kasir', 'user', 'pelanggan') DEFAULT 'user'");
            
            // 2. Safely update data
            DB::table('users')->where('role', 'user')->update(['role' => 'pelanggan']);
            
            // 3. Narrow ENUM to remove 'user'
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'kasir', 'pelanggan') DEFAULT 'pelanggan'");
        } catch (\Exception $e) {
            // SQLite fallback: just update the string data
            DB::table('users')->where('role', 'user')->update(['role' => 'pelanggan']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->where('role', 'pelanggan')->update(['role' => 'user']);
        
        try {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'kasir', 'user') DEFAULT 'user'");
        } catch (\Exception $e) {
            // Ignore for SQLite
        }
    }
};
