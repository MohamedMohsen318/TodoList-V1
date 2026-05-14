<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('roles')
            ->where('guard_name', 'admin')
            ->where('name', 'super-admin')
            ->update(['name' => 'super_admin']);
    }

    public function down(): void
    {
        DB::table('roles')
            ->where('guard_name', 'admin')
            ->where('name', 'super_admin')
            ->update(['name' => 'super-admin']);
    }
};

