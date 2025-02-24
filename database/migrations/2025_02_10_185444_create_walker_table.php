<?php

use App\Models\Registration;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email');
            $table->boolean('finished')->default(false);
            $table->timestamp('registration_date')->useCurrent();
            $table->timestamps();
        });

        Schema::create('walkers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email')->nullable();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable()->default('Belgium');
            $table->date('date_of_birth')->nullable();
            $table->string('club_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('tshirt_size')->nullable();
            $table->string('display_name')->nullable();
            $table->boolean('display_accepted')->default(false);
            $table->boolean('gdpr_accepted')->default(false);
            $table->foreignIdFor(Registration::class)->constrained('registrations')->cascadeOnDelete();
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
