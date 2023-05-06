<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuid;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_organizer',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_organizer' => 'boolean',
    ];

    public function scopeCustomer($q)
    {
        return $q->where('is_organizer', false);
    }

    public function ownedLoyaltyPrograms(): HasMany
    {
        return $this->hasMany(LoyaltyProgram::class, 'organizer_id');
    }

    public function loyaltyPrograms(): BelongsToMany
    {
        return $this->belongsToMany(LoyaltyProgram::class, 'participants', 'participant_id', 'loyalty_program_id')
            ->withPivot('points')
            ->using(Participant::class)
            ->withTimestamps();
    }

    public function initiatedBarters()
    {
        return $this->hasMany(Barter::class, 'initiator_id');
    }
}
