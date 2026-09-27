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
        Schema::table('admission', function (Blueprint $table) {
            $table->unsignedBigInteger('room_id')->nullable()->after('status');
            $table->unsignedBigInteger('bed_id')->nullable()->after('room_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admission', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropForeign(['bed_id']);
            $table->dropColumn(['room_id', 'bed_id']);
        });
    }
};
