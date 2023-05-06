<?php

namespace App\Http\Controllers;

use App\Services\HuntService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HuntController extends Controller
{
    public function index()
    {
        $service = app(HuntService::class, ['user' => Auth::user()]);

        $hunts = $service->hunts();

        return Inertia::render('Hunts/Index', [
            'hunts' => $hunts,
        ]);
    }
}
