<?php

namespace App\Http\Controllers;

use App\Services\HuntService;
use Carbon\Carbon;
use Illuminate\Support\Arr;
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

    public function show(int $id)
    {
        $service = app(HuntService::class, ['user' => Auth::user()]);

        $hunt = $service->huntDetail($id);

        return Inertia::render('Hunts/Show', [
            'hunt' => $hunt,
        ]);
    }

    public function claim()
    {
        $service = app(HuntService::class, ['user' => Auth::user()]);

        session()->flash('success', $service->claimHunt(request('riddle_token'), request('answer')));

        return back();
    }
}
