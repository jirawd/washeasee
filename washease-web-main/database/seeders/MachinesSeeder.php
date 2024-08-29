<?php

namespace Database\Seeders;

use App\Models\Machines;
use Database\Factories\MachinesFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MachinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MachinesFactory::factoryForModel('Machines')->count(50000)->create();
    }
}
