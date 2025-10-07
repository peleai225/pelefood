<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Mettre à jour les valeurs existantes
        DB::statement("ALTER TABLE orders MODIFY COLUMN type ENUM('on_site', 'delivery', 'takeaway') DEFAULT 'delivery'");
        
        // Mettre à jour les valeurs existantes si nécessaire
        DB::table('orders')->where('type', 'pickup')->update(['type' => 'takeaway']);
        DB::table('orders')->where('type', 'dine_in')->update(['type' => 'on_site']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revenir aux anciennes valeurs
        DB::statement("ALTER TABLE orders MODIFY COLUMN type ENUM('delivery', 'pickup', 'dine_in') DEFAULT 'delivery'");
        
        // Mettre à jour les valeurs si nécessaire
        DB::table('orders')->where('type', 'takeaway')->update(['type' => 'pickup']);
        DB::table('orders')->where('type', 'on_site')->update(['type' => 'dine_in']);
    }
};
