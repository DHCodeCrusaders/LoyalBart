<?php

namespace App\Http\Controllers;

use App\Models\Barter;
use Inertia\Inertia;

class ListBarterController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Barters/Index', [
            'barters' => Barter::query()
                ->active()
                ->with('initiator', 'offeredProgram', 'requestedProgram')
                ->get()
        ]);
    }
}
