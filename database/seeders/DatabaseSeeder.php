<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;


    public function run(): void
    {
       \App\Models\Document::factory()->count(10)->create([
            'created_by' => 5,
            'status' => 'active'
        ]);

        \App\Models\Document::factory()->count(5)->create([
            'receiver_id' => 5,
            'status' => 'active'
        ]);

        $docs = \App\Models\Document::where('created_by', 5)->take(3)->get();
        foreach ($docs as $doc) {
            \App\Models\DocumentSignature::create([
                'document_id' => $doc->id,
                'user_id' => 5,
                'status' => 'signed',
                'signature' => 'digital-sig-data'
            ]);
        }
    }
}
