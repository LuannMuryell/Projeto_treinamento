<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit($id)
    {

        $authUser = Auth::user();

        if($authUser->profile == 'A'){
            return redirect()->route('home');
        }

        $user = User::findOrFail($id);

        return Inertia::render('Profile/Edit', [
            'user' => $user,
            'mustVerifyEmail' => $user instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, string $id)
    {

        $authUser = Auth::user();

            if($authUser->profile != 'A'){

                $user = User::find($id); 

                $data = [
                    'name' => $request->name,
                    'profile' => $request->profile,
                    'active' => $request->active,
                ];

                $user->update($data);
                
                return redirect()->route('profile.edit', $user->id)->with('status', 'Perfil atualizado com sucesso!');
            }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
