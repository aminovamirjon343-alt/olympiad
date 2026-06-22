<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'owner_id',
    ];

    // ✅ Связь с пользователями компании
    public function users()
    {
        return $this->hasMany(User::class, 'company_id');
    }

    // ✅ Связь с владельцем (админом)
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}