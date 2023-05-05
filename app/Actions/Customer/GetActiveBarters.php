<?php

namespace App\Actions\Customer;

use App\Models\Barter;

class GetActiveBarters
{
    public function handle(): \Illuminate\Database\Eloquent\Collection
    {
        return Barter::query()
            ->active()
            ->get();
    }
}
