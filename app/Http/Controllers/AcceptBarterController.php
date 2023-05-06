<?php

namespace App\Http\Controllers;

use App\Actions\Customer\AcceptBarter;
use App\Models\Barter;
use Illuminate\Support\Facades\Auth;

class AcceptBarterController extends Controller
{
    public function __invoke(Barter $barter)
    {
        try {
            app()->make(AcceptBarter::class)->handle(
                $barter,
                Auth::user()
            );

            return back()->with('success', 'Congratulations! The barter has been successfully executed.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
