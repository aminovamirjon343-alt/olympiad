<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title',
        'content',
        'file_path',
        'status',
        'created_by',
        'deadline'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Подписи
    public function signatures()
    {
        return $this->hasMany(documentSignature::class);
    }

    // Workflow
    public function workflows()
    {
        return $this->hasMany(documentWorkflow::class);
    }

    // Логи
    public function logs()
    {
        return $this->hasMany(documentLog::class);
    }

    // Комментарии
    public function comments()
    {
        return $this->hasMany(documentComment::class);
    }

    // Версии
    public function versions()
    {
        return $this->hasMany(documentVersion::class);
    }
}
