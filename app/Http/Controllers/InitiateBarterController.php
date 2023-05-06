<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyProgram;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Actions\Customer\InitiateBarter;

class InitiateBarterController extends Controller
{
    public function __invoke()
    {
        $data = request()->validate([
            'offered_program' => 'required|exists:loyalty_programs,id',
            'requested_program' => 'required|exists:loyalty_programs,id',
            'requested_points' => 'required|integer|min:1',
            'offered_points' => 'required|integer|min:1',
        ]);

        try {
            $barter = app()->make(InitiateBarter::class)->handle(
                Auth::user(),
                LoyaltyProgram::find($data['offered_program']),
                $data['offered_points'],
                LoyaltyProgram::find($data['requested_program']),
                $data['requested_points'],
            );

            session(['success' => 'Barter initiated successfully..']);

            return "Hello baby!";
        } catch (\Exception $e) {
            session(['error' => $e->getMessage()]);
        }

        return back();
    }
}
