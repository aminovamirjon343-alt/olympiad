<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаем 10 документов специально для пользователя с ID 5
        \App\Models\Document::factory()->count(10)->create([
            'created_by' => 5,
        ]);

        // И еще 10 случайных для других
        \App\Models\Document::factory()->count(10)->create();
    }
}
