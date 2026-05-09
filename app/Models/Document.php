<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Document extends Model
{
    use SoftDeletes;

    // Константы статусов
    const STATUS_DRAFT = 'draft';
    const STATUS_ACTIVE = 'active';
    const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'number',
        'title',
        'content',
        'type',
        'file_path',
        'status',
        'created_by',
        'receiver_id',
        'deadline'
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    /**
     * Scope: Фильтрация документов в зависимости от роли (Админ или Сотрудник)
     */
    public function scopeVisibleToAuth($query)
    {
        $user = Auth::user();

        if (!$user) return $query->whereRaw('1 = 0'); // Если не залогинен — ничего не показывать

        // Если админ — видит всё (фильтр не добавляем)
        if ($user->is_admin) {
            return $query;
        }

        // Если обычный пользователь — только свои или входящие
        return $query->where(function($q) use ($user) {
            // 1. Автор видит свои документы в любом статусе (даже черновики)
            $q->where('created_by', $user->id)
                // 2. А получатель видит документ ТОЛЬКО если статус НЕ черновик
                ->orWhere(function($subQ) use ($user) {
                    $subQ->where('receiver_id', $user->id)
                        ->where('status', '!=', self::STATUS_DRAFT);
                });
        });
    }

    /**
     * Отношения
     */

    // Кто создал (автор)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Тот же автор (алиас для удобства)
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Получатель документа
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // Подписи к документу
    public function signatures(): HasMany
    {
        return $this->hasMany(DocumentSignature::class);
    }

    // Логи действий
    public function logs(): HasMany
    {
        return $this->hasMany(DocumentLog::class);
    }

    /**
     * Хелперы проверки состояния
     */

    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    // Ожидает подписи (Активен, но подписи еще нет)
    public function isWaiting(): bool
    {
        return $this->status === self::STATUS_ACTIVE &&
            !$this->signatures()->where('signature', '!=', '')->exists();
    }

    // Подписан (Активен И есть подпись)
    public function isSigned(): bool
    {
        return $this->status === self::STATUS_ACTIVE &&
            $this->signatures()->where('signature', '!=', '')->exists();
    }

    /**
     * Проверка прав доступа к конкретному документу
     */
    public function canManage(): bool
    {
        $user = Auth::user();
        if (!$user) return false;

        // Админ может всё, либо автор может управлять своим
        return $user->is_admin || $this->created_by === $user->id;
    }

    /**
     * Аксессоры для UI (Бейджи и Тексты)
     */

    // Текстовая метка статуса
    public function getStatusLabelAttribute(): string
    {
        if ($this->status === self::STATUS_DRAFT) return 'ЧЕРНОВИК';
        if ($this->status === self::STATUS_REJECTED) return 'ОТКЛОНЕН';

        return $this->isSigned() ? 'ПОДПИСАН' : 'ОЖИДАЕТ';
    }

    // CSS Классы для Tailwind
    public function getStatusStyleAttribute(): string
    {
        if ($this->status === self::STATUS_DRAFT) {
            return 'bg-gray-100 text-gray-600 border-gray-300';
        }

        if ($this->status === self::STATUS_REJECTED) {
            return 'bg-red-50 text-red-600 border-red-600';
        }

        if ($this->isSigned()) {
            return 'bg-green-50 text-green-600 border-green-600';
        }

        return 'bg-yellow-50 text-yellow-600 border-yellow-600';
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
