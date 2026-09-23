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
        $driver = DB::getDriverName();
        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=off;');
            DB::statement('ALTER TABLE users RENAME TO users_old;');
            
            DB::statement('CREATE TABLE "users" (
                "id" integer primary key autoincrement not null,
                "name" varchar not null,
                "email" varchar not null,
                "phone" varchar,
                "role" varchar check ("role" in (\'penghuni\', \'owner\', \'tenant\')) not null default \'penghuni\',
                "email_verified_at" datetime,
                "password" varchar not null,
                "remember_token" varchar,
                "created_at" datetime,
                "updated_at" datetime,
                "ktp_file" varchar
            );');

            DB::statement("INSERT INTO users (id, name, email, phone, role, email_verified_at, password, remember_token, created_at, updated_at, ktp_file)
                SELECT id, name, email, phone, CASE WHEN role = 'tenant' THEN 'penghuni' ELSE role END, email_verified_at, password, remember_token, created_at, updated_at, ktp_file
                FROM users_old;");

            DB::statement('DROP TABLE users_old;');
            DB::statement('PRAGMA foreign_keys=on;');
        } else {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('penghuni', 'owner') DEFAULT 'penghuni';");
            DB::table('users')->where('role', 'tenant')->update(['role' => 'penghuni']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=off;');
            DB::statement('ALTER TABLE users RENAME TO users_old;');
            
            DB::statement('CREATE TABLE "users" (
                "id" integer primary key autoincrement not null,
                "name" varchar not null,
                "email" varchar not null,
                "phone" varchar,
                "role" varchar check ("role" in (\'tenant\', \'owner\')) not null default \'tenant\',
                "email_verified_at" datetime,
                "password" varchar not null,
                "remember_token" varchar,
                "created_at" datetime,
                "updated_at" datetime,
                "ktp_file" varchar
            );');

            DB::statement("INSERT INTO users (id, name, email, phone, role, email_verified_at, password, remember_token, created_at, updated_at, ktp_file)
                SELECT id, name, email, phone, CASE WHEN role = 'penghuni' THEN 'tenant' ELSE role END, email_verified_at, password, remember_token, created_at, updated_at, ktp_file
                FROM users_old;");

            DB::statement('DROP TABLE users_old;');
            DB::statement('PRAGMA foreign_keys=on;');
        }
    }
};
