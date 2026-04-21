<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasColumn('documents', 'created_by')) {
            Schema::table('documents', function (Blueprint $table) {
                $table->foreignId('created_by')
                    ->constrained('users')
                    ->cascadeOnDelete()
                    ->after('status');
            });
        }
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });
    }
};
