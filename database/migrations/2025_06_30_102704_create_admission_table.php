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
        Schema::create('admission', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('parent_number');
            $table->date('dob');
            $table->date('admission_date');
            $table->string('address');
            $table->string('pincode');
            $table->string('adhar_number');
            $table->string('pan_number')->nullable();
            $table->string('doc_admission')->nullable();
            $table->string('photo');
            $table->string('doc_adhar');
            $table->string('doc_pan');
            $table->string('doc_qualification');

            $table->enum('gender', ['male', 'female']);
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission');
    }
};
