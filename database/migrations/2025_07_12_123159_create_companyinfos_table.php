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
        Schema::create('companyinfos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('owner');
            $table->string('CompanyName');
            $table->string('CompanyEmail');
            $table->string('mobile');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('pincode')->nullable();
            $table->string('state')->nullable();
            $table->string('rc')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('gst')->nullable();
            $table->string('bankName')->nullable();
            $table->string('acount')->nullable();
            $table->string('ifsc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companyinfos');
    }
};
