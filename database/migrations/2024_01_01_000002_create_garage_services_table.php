<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('garage_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('garage_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('duration')->comment('Duration in minutes');
            $table->boolean('is_available')->default(true);
            $table->string('category')->nullable();
            $table->timestamps();
            
            $table->index(['garage_id', 'is_available']);
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('garage_services');
    }
}; 