<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('walkers', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable()->default('Belgium');
            $table->uuid()->default(Str::uuid()->toString());
            $table->date('date_of_birth')->nullable();
            $table->string('club_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('tshirt_size')->nullable();
            $table->string('display_name')->nullable();
            $table->boolean('display_accepted')->default(false);
            $table->boolean('gdpr_accepted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('walkers');
    }
};
