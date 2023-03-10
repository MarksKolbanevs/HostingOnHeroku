<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Storage;

class StorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Storage::factory()->count(10)->create();
    }
}
