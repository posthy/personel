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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained(table: "persons")->cascadeOnDelete();
            $table->enum("address_type", ["permanent", "temporary"]);
            $table->string("country", 100);
            $table->string("city", 100);
            $table->string("street", 150);
            $table->string("number", 10);
            $table->string("zip", 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
