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
            // Colonnes pour le profil
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('email');
            }
            
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('avatar');
            }
            
            if (!Schema::hasColumn('users', 'job_title')) {
                $table->string('job_title')->nullable()->after('bio');
            }
            
            if (!Schema::hasColumn('users', 'department')) {
                $table->string('department')->nullable()->after('job_title');
            }
            
            if (!Schema::hasColumn('users', 'website')) {
                $table->string('website')->nullable()->after('department');
            }
            
            if (!Schema::hasColumn('users', 'linkedin')) {
                $table->string('linkedin')->nullable()->after('website');
            }
            
            if (!Schema::hasColumn('users', 'twitter')) {
                $table->string('twitter')->nullable()->after('linkedin');
            }
            
            if (!Schema::hasColumn('users', 'facebook')) {
                $table->string('facebook')->nullable()->after('twitter');
            }
            
            if (!Schema::hasColumn('users', 'instagram')) {
                $table->string('instagram')->nullable()->after('facebook');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'avatar', 'bio', 'job_title', 'department', 
                'website', 'linkedin', 'twitter', 'facebook', 'instagram'
            ]);
        });
    }
};