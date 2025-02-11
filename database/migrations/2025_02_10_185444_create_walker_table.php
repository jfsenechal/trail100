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
        Schema::create('walker', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('country')->nullable()->default('Belgium');
            $table->string('last_name');
            $table->string('first_name');
            $table->uuid()->default(Str::uuid()->toString());
            $table->date('date_of_birth')->nullable();
            $table->string('club_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('tshirt_size')->nullable();
            $table->string('display_name')->nullable();
            $table->boolean('gdpr_accepted')->default(false);
            $table->foreignIdFor(User::class)->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('walker');
    }
};
