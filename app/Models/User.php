<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Notifications\DocumentAssigned; // Импорт твоего класса уведомлений

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone'
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
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'created_by');
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

