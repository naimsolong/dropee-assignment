<?php

namespace Database\Seeders;

use App\Models\Sentence;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('123456'),
        ]);

        $user->setting()->create([
            'row' => 4,
            'column' => 4,
        ]);

        $user->sentences()->saveMany([
            new Sentence([
                'value' => 'Dropee.com',
                'row' => 1,
                'column' => 2,
            ]),
            new Sentence([
                'value' => 'B2B Marketplace',
                'row' => 3,
                'column' => 1,
            ]),
            new Sentence([
                'value' => 'SaaS enabled marketplace',
                'row' => 2,
                'column' => 3,
            ]),
            new Sentence([
                'value' => 'Provide Transparency',
                'row' => 4,
                'column' => 4,
            ]),
            new Sentence([
                'value' => 'Build Trust',
                'row' => 1,
                'column' => 4,
            ]),
        ]);
    }
}
