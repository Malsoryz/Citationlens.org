<?php

namespace Database\Seeders;

use App\Models\Journal;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JournaDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Journal::create([
            'name' => 'example',
            'oai_path' => 'example.com',
            'max_list_record' => 1,
            'bpress' => true,
            'eprint' => false,
        ]);
    }
}
