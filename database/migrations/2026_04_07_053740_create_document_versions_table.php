<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('document_versions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('document_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('version');
            $table->string('file_path')->nullable();

            // Поле для описания изменений (полезно для Модуля №11: История)
            $table->text('change_summary')->nullable();

            $table->timestamps();

            // Уникальный индекс: у одного документа не может быть двух одинаковых номеров версий
            $table->unique(['document_id', 'version']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_versions');
    }
};
