<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'whatsapp_number',
        'description',
        'remember_token',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'user_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function tokens(): HasMany
    {
        return $this->hasMany(PerAccessToken::class);
    }

    public function lastToken(): HasMany
    {
        return $this->hasMany(PerAccessToken::class)->latest();
    }

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}
