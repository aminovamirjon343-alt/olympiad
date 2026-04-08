<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Document;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Массовое заполнение
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Скрытые поля
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Приведение типов
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Документы пользователя (кто создал)
     */
    public function documents()
    {
        return $this->hasMany(Document::class, 'created_by');
    }
}
