<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            if (!Schema::hasColumn('restaurants', 'slogan')) {
                $table->string('slogan')->nullable()->after('description');
            }
            if (!Schema::hasColumn('restaurants', 'postal_code')) {
                $table->string('postal_code')->nullable()->after('city');
            }
            if (!Schema::hasColumn('restaurants', 'country')) {
                $table->string('country')->nullable()->after('postal_code');
            }
            if (!Schema::hasColumn('restaurants', 'delivery_radius')) {
                $table->integer('delivery_radius')->default(10)->after('delivery_time');
            }
            if (!Schema::hasColumn('restaurants', 'preparation_time')) {
                $table->integer('preparation_time')->default(30)->after('delivery_radius');
            }
            if (!Schema::hasColumn('restaurants', 'website')) {
                $table->string('website')->nullable()->after('website_url');
            }
            if (!Schema::hasColumn('restaurants', 'currency')) {
                $table->string('currency', 3)->default('XOF')->after('website');
            }
            if (!Schema::hasColumn('restaurants', 'timezone')) {
                $table->string('timezone')->default('Africa/Abidjan')->after('currency');
            }
            if (!Schema::hasColumn('restaurants', 'language')) {
                $table->string('language', 2)->default('fr')->after('timezone');
            }
            if (!Schema::hasColumn('restaurants', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade')->after('verified_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn([
                'slogan', 'postal_code', 'country', 'delivery_radius', 
                'preparation_time', 'website', 'currency', 'timezone', 'language'
            ]);
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
