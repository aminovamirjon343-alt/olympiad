<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'type',
        'file_path',
        'user_id',
        'status',
        'created_by',
        'deadline'
    ];
    protected $casts = [
        'deadline' => 'datetime',
    ];


    public function signatures()
    {
        return $this->hasMany(documentSignature::class);
    }

    public function workflows()
    {
        return $this->hasMany(documentWorkflow::class);
    }


    public function logs()
    {
        return $this->hasMany(documentLog::class);
    }


    public function comments()
    {
        return $this->hasMany(documentComment::class);
    }


    public function versions()
    {
        return $this->hasMany(documentVersion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
