<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Notifications\DocumentAssigned;
use Illuminate\Support\Facades\Cache;


// Импорт твоего класса уведомлений

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    public function isOnline()
    {
        return \Illuminate\Support\Facades\Cache::has('user-is-online-' . $this->id);
    }
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'company',
        'phone',


    ];

    protected $attributes = [
        'role' => 'user',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        $first = mb_strtoupper(mb_substr($words[0] ?? '', 0, 1));
        $second = isset($words[1]) ? mb_strtoupper(mb_substr($words[1], 0, 1)) : '';
        return $first . $second;
    }


    public function documents()
    {
        return $this->hasMany(\App\Models\Document::class, 'created_by');
    }

    public function sendDocumentNotification($document)
    {
       return $this->notify(new DocumentAssigned($document));
    }

}

