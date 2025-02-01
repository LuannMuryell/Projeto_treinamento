<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Requests\UsersRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $authUser = Auth::user();
        if($authUser->profile == 'A'){
            return redirect()->route('home');
        }

        $users = User::paginate(8);
        return Inertia::render('Users/Users', ['users' => $users, 'authUser' => $authUser]);
    }

    public function create()
    {
        $authUser = Auth::user();
        if($authUser->profile == 'A'){
            return redirect()->route('home');
        }
        return Inertia::render('Auth/Register');
    }

    public function store(UsersRequest $request){

        $authUser = Auth::user();

        if($authUser->profile != 'A'){

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'cpf' => $request->cpf,
                'profile' => $request->profile
            ];

            User::create($data);
        }
    }

    public function edit(string $id)
    {
        $authUser = Auth::user();

        if($authUser->profile == 'A'){
            return redirect()->route('home');
        }

        $user = User::find($id);
        return Inertia::render('Profile/Edit', ['user' => $user]);
    }

    public function update(UsersRequest $request, string $id)
    {
        $authUser = Auth::user();

        if($authUser->profile != 'A'){

            $user = User::find($id);

        $data = [
            'name' => $request->name,
            'cpf' => $request->cpf,
            'email' => $request->email,
            'profile' => $request->profile,
            'active' => $request->active,
            'password' => $request->password
        ];

        $user->update($data);   
        }
    }

    public function deactivate(Request $request, string $id)
    {
        $authUser = Auth::user();

        if($authUser->profile != 'A'){ 

            $user = User::find($id);

            $data = [
                'active' => $request->active
            ];
            $user->update($data);
        }
    }
}

