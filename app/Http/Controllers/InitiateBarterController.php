<?php

namespace App\Http\Controllers;

use App\Actions\Customer\InitiateBarter;
use App\Models\LoyaltyProgram;
use Illuminate\Support\Facades\Auth;

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
            app()->make(InitiateBarter::class)->handle(
                Auth::user(),
                LoyaltyProgram::find($data['offered_program']),
                $data['offered_points'],
                LoyaltyProgram::find($data['requested_program']),
                $data['requested_points'],
            );

            session()->flash('success', 'Barter initiated successfully..');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return back();
    }
}
