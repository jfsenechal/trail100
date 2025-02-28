<?php

namespace Database\Seeders;

use App\Models\Registration;
use App\Models\Role;
use App\Models\User;
use App\Models\Walker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    protected static ?string $password;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::factory()->create([
            'name' => Role::ROLE_ADMIN,
        ]);
        $runnerRole = Role::factory()->create([
            'name' => Role::ROLE_WALKER,
        ]);
        $user = User::factory()
            ->hasAttached($adminRole)
            ->hasAttached($runnerRole)
            ->create([
                'first_name' => 'Jf',
                'last_name' => 'Sénéchal',
                'email' => 'jf@marche.be',
                'password' => static::$password ??= Hash::make('marge'),
            ]);

        $registration = Registration::factory()->create([
            'email' => 'jf@marche.be',
            'gdpr_accepted' => true,
            'newsletter_accepted' => true,
            'completed' => true,
            'payment_date' => now(),
        ]);

        Walker::factory(3)->create(['registration_id' => $registration->id]);

        User::factory(4)->hasAttached($adminRole)->create();

        Registration::factory(6)->create([
            'gdpr_accepted' => true,
        ])->each(function (Registration $registration) {
            Walker::factory(rand(1, 5))->create([
                'registration_id' => $registration->id,
            ]);
        });
    }


}
