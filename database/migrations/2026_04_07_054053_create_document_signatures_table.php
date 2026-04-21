<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('document_signatures', function (Blueprint $table) {
            $table->id();

            $table->foreignId('document_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->longText('signature'); // base64
            $table->timestamp('signed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_signatures');
    }
};
