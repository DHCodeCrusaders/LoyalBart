<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HuntController extends Controller
{
    public function index()
    {
        return Inertia::render('Organizer/Hunts/Index', [
            'hunts' => auth()->user()->hunts,
        ]);
            
    }
}
