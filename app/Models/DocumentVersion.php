<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentVersion extends Model
{
    protected $fillable = [
        'document_id',
        'version',
        'file_path'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
