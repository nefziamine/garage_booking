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
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('phone')->nullable()->after('email');
            $table->string('city')->nullable()->after('phone');
            $table->string('garage_name')->nullable()->after('city');
            $table->text('address')->nullable()->after('garage_name');
            $table->json('specialties')->nullable()->after('address');
            $table->string('experience_years')->nullable()->after('specialties');
            $table->enum('user_type', ['client', 'garage'])->default('client')->after('experience_years');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'phone',
                'city',
                'garage_name',
                'address',
                'specialties',
                'experience_years',
                'user_type'
            ]);
        });
    }
};
