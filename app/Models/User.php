<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

class User extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable, SoftDeletes, CanResetPasswordTrait;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'phone',
        'role',
        'company',
        'company_id',
        'created_by',
        'level',
        'is_admin',
        'is_super_admin',
        'last_seen_at',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_seen_at' => 'datetime',
        'password' => 'hashed',
        'level' => 'integer',
        'is_admin' => 'boolean',
        'is_super_admin' => 'boolean',
    ];

    protected $attributes = [
        'role' => 'employee',
        'level' => 2,
        'is_admin' => false,
        'is_super_admin' => false,
    ];

    // ===== МЕТОДЫ ДЛЯ ВОССТАНОВЛЕНИЯ ПАРОЛЯ =====

    /**
     * Получить email для отправки ссылки восстановления пароля
     * (требуется интерфейсом CanResetPassword)
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    /**
     * Отправить уведомление о сбросе пароля
     * (переопределяем для кастомизации, если нужно)
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \Illuminate\Auth\Notifications\ResetPassword($token));
    }

    // ===== МЕТОДЫ ПРОВЕРКИ РОЛЕЙ =====

    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin === true;
    }

    public function isAdmin(): bool
    {
        return $this->is_admin === true || $this->level === 1;
    }

    public function isEmployee(): bool
    {
        return !$this->isAdmin() && !$this->isSuperAdmin();
    }

    public function isOnline(): bool
    {
        if (!$this->last_seen_at) {
            return false;
        }
        return $this->last_seen_at->gt(now()->subMinutes(5));
    }

    // ===== СВЯЗИ =====

    public function companyRelation()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function subordinates()
    {
        return $this->hasMany(User::class, 'created_by');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'created_by');
    }

    // ===== АКСЕССУАРЫ =====

    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        $first = mb_strtoupper(mb_substr($words[0] ?? '', 0, 1));
        $second = isset($words[1]) ? mb_strtoupper(mb_substr($words[1], 0, 1)) : '';
        return $first . $second;
    }
}