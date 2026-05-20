<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('house_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('week_number');
            $table->unsignedSmallInteger('year');
            $table->dateTime('paid_at');
            $table->foreignId('recorded_by')->constrained('users')->onDelete('cascade');
            $table->unsignedInteger('amount')->default(1000);
            $table->timestamps();

            $table->unique(['house_id', 'week_number', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
