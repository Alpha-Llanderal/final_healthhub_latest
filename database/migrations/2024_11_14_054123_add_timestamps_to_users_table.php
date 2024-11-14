<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToUsersTable extends Migration
{
    public function up()
    {
        // Check if `created_at` column exists
        if (!Schema::hasColumn('users', 'created_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('created_at')->nullable();
            });
        }

        // Check if `updated_at` column exists
        if (!Schema::hasColumn('users', 'updated_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('updated_at')->nullable();
            });
        }
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }
}

