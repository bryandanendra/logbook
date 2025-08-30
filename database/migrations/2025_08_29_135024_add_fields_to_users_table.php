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
            $table->enum('role', ['admin', 'estimator'])->default('estimator')->after('password');
            $table->string('department')->nullable()->after('role');
            $table->string('position')->nullable()->after('department');
            $table->string('employee_id')->unique()->nullable()->after('position');
            $table->boolean('is_active')->default(true)->after('employee_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'department', 'position', 'employee_id', 'is_active']);
        });
    }
};
