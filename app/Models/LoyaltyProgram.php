<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LoyaltyProgram extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'title',
        'description',
        'photo',
        'organizer_id',
    ];

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class)
            ->where('is_organizer', true);
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'loyalty_participants', 'participant_id', 'loyalty_program_id')
            ->withPivot('points')
            ->using(LoyaltyProgramParticipant::class)
            ->withTimestamps();
    }
}
