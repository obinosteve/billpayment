<?php

namespace Database\Seeders;

use App\Models\NetworkProvider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NetworkProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['MTN', 'GLO', 'AIRTEL', 'ETISALAT'] as $network) {
            NetworkProvider::create(['name' => $network]);
        }
    }
}
