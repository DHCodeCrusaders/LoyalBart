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
        return $this->belongsTo(User::class);
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'participants', 'loyalty_program_id', 'participant_id')
            ->withPivot('points')
            ->using(Participant::class)
            ->withTimestamps();
    }
}
