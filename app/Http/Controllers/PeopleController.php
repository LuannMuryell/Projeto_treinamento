<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\People;
use Inertia\Inertia;

class PeopleController extends Controller
{
    public function index(){
        $people = People::all();
        return Inertia::render('People/People', ['people' => $people]);
    }

    public function create(){
        return Inertia::render('People/RegisterPeople');
    }

    public function store(Request $request)
    {
        $data = new People;
            $data->name = $request->name;
            $data->cpf = $request->cpf;
            $data->birth_date = $request->birth_date;
            $data->gender = $request->gender;
            $data->phone = $request->phone;
            $data->email = $request->email;

        $data->save();

        return redirect('/pessoas');
    }
}


