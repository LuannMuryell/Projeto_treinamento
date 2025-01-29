<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request, string $id): RedirectResponse
{
    $validated = $request->validate(
        [
            'password' => ['required', Password::defaults(), 'confirmed'],
        ],
        [
            'password.required' => 'O campo nova senha é obrigatório',
            'password.confirmed' => 'As senhas não são iguais'
        ]
    );

   $user = User::find($id);

   $user->update([
       'password' => Hash::make($validated['password']),
   ]);
    return back();
}

}
