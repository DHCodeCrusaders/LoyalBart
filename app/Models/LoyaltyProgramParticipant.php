<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class LoyaltyProgramParticipant extends Pivot
{
    use HasFactory;

    protected $table = 'loyalty_participants';

    protected $fillable = [
        'loyalty_program_id',
        'participant_id',
        'points'
    ];

    public function loyaltyProgram(): BelongsTo
    {
        return $this->belongsTo(LoyaltyProgram::class);
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
