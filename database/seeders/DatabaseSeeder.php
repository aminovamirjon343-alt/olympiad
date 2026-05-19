<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Создаем 10 документов, где Амир (ID 5) — автор
        \App\Models\Document::factory()->count(10)->create([
            'created_by' => 5,
            'status' => 'active'
        ]);

        // 2. Создаем 5 документов, где Амир (ID 5) — получатель
        \App\Models\Document::factory()->count(5)->create([
            'receiver_id' => 5,
            'status' => 'active'
        ]);

        // 3. Создаем записи о подписях для этих документов
        $docs = \App\Models\Document::where('created_by', 5)->take(3)->get();
        foreach ($docs as $doc) {
            \App\Models\DocumentSignature::create([
                'document_id' => $doc->id,
                'user_id' => 5,
                'status' => 'signed',
                'signature' => 'digital-sig-data' // Обязательно заполни это поле!
            ]);
        }
    }
}
