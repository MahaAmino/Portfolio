<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_mes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('your_name');
            $table->string('your_email');
            $table->text('your_message');

        });
    }
    public function down(): void
    {
        Schema::dropIfExists('contact_mes');
    }
};
