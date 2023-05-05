<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barter extends Model
{
    use HasFactory;

    protected $fillable = [
        'initiator_id',
        'offered_program_id',
        'offered_points',
        'requested_program_id',
        'requested_points',
        'acceptor_id',
        'accepted_at',
    ];

    protected $casts = [
        'accepted_at' => 'datetime',
    ];

    public function scopeActive(Builder $q)
    {
        return $q
            ->where('created_at', '>=', now()->subDay())
            ->where('acceptor_id', null)
            ->where('accepted_at', null);
    }

    public function requestedProgram(): BelongsTo
    {
        return $this->belongsTo(LoyaltyProgram::class, 'requested_program_id');
    }

    public function offeredProgram(): BelongsTo
    {
        return $this->belongsTo(LoyaltyProgram::class, 'offered_program_id');
    }

    public function initiator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'initiator_id');
    }

    public function acceptor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'acceptor_id');
    }

    public function hasExpired(): bool
    {
        return $this->created_at->diffInDays(now()) >= 1;
    }
}
