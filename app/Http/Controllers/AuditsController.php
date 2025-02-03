<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Models\Audit;
use Inertia\Inertia;

class AuditsController extends Controller
{
    public function index()
    {
        $authUser = Auth::user();
        if($authUser->profile == 'A'){
            return redirect()->route('home');
        }

        $audits = Audit::with('user')->latest()->paginate(10);

        return Inertia::render('Audits/Audits', ['audits' => $audits]);
    }
}
