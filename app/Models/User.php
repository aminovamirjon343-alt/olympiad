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
    // В начало файла внутри класса User
    public function isOnline()
    {
        return \Illuminate\Support\Facades\Cache::has('user-is-online-' . $this->id);
    }
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'created_by',

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

    /**
     * Инициалы пользователя (например, Иван Иванов -> ИИ)
     */
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        $first = mb_strtoupper(mb_substr($words[0] ?? '', 0, 1));
        $second = isset($words[1]) ? mb_strtoupper(mb_substr($words[1], 0, 1)) : '';
        return $first . $second;
    }

    /**
     * Связь с документами (созданными этим пользователем)
     * Используем 'created_by', так как в миграции поле называется именно так.
     */
    public function documents()
    {
        // Связь один-ко-многим: один пользователь создает много документов
        return $this->hasMany(\App\Models\Document::class, 'created_by');
    }
    /**
     * Метод для отправки уведомления (исправленный под стандарт Laravel)
     */
    public function sendDocumentNotification($document)
    {
        // Вместо ручного Notification::create используем системный метод
        // Это автоматически запишет данные в таблицу notifications через morphs
        return $this->notify(new DocumentAssigned($document));
    }

}

