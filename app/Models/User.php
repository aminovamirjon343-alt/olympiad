<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

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
        'is_admin',          // ✅ Добавлено
        'is_super_admin',
        'last_seen_at',      // ✅ Добавлено
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_seen_at' => 'datetime',  // ✅ Добавлено
        'level' => 'integer',
        'is_admin' => 'boolean',       // ✅ Добавлено
        'is_super_admin' => 'boolean',
    ];

    protected $attributes = [
        'role' => 'employee',
        'level' => 1,
        'is_admin' => false,
        'is_super_admin' => false,
    ];

    public function isAdmin(): bool
    {
        return $this->is_admin || $this->level === 1;
    }

    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin;
    }

    public function isOnline()
    {
        return $this->last_seen_at && $this->last_seen_at->diffInMinutes(now()) < 5;
    }

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

    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        $first = mb_strtoupper(mb_substr($words[0] ?? '', 0, 1));
        $second = isset($words[1]) ? mb_strtoupper(mb_substr($words[1], 0, 1)) : '';
        return $first . $second;
    }
}