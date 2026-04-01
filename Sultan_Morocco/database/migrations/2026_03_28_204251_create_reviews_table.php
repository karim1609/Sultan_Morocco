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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('place_id')->constrained()->cascadeOnDelete();
            $table->integer('rating'); // Validate 1-5 in business logic, or DB level. Laravel standard is app level, but I will just use integer here. I will add a check constraint for the DB level since the user said "Validate rating between 1 and 5", though this is usually app-level. Actually constraints can be added like so: `->check('rating >= 1 AND rating <= 5')`. No, check constraints aren't natively supported beautifully on all DBs or old larabels, but Laravel 11 handles it or we just use integer. The rule says "Validate rating between 1 and 5". I'll add an unsigned integer and leave it at that, or maybe just `->unsignedTinyInteger()`.
            $table->text('comment');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
