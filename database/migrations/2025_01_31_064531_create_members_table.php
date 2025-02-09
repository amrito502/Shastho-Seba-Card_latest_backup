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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('fatherName');
            $table->string('motherName');
            $table->string('nid');
            $table->string('dob');
            $table->string('gender');
            $table->string('religion');
            $table->string('mobile');
            $table->string('member_photo');
            $table->string('age');
            $table->string('address');
            $table->json('family_members')->nullable();
            $table->foreignId('admin_id')->nullable()->default(null)->constrained('users')->onDelete('cascade');
            $table->foreignId('card_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('district_id')->constrained()->onDelete('cascade')->default(1);
            $table->foreignId('sub_district_id')->constrained('sub_districts')->onDelete('cascade')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
