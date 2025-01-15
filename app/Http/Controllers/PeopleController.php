<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Person;
use Inertia\Inertia;

class PeopleController extends Controller
{
    public function index(){
        $people = Person::all();
        return Inertia::render('People/People', ['people' => $people]);
    }

    public function create(){
        return Inertia::render('People/RegisterPeople');
    }

    public function store(Request $request)
    {
        $data = new Person;
            $data->name = $request->name;
            $data->cpf = $request->cpf;
            $data->birth_date = $request->birth_date;
            $data->gender = $request->gender;
            $data->phone = $request->phone;
            $data->email = $request->email;

        $data->save();
    }

    public function edit(string $id){

        $person = Person::find($id);

        return Inertia::render('People/EditPeople', ['person' => $person]);
    }

    public function update(Request $request, string $id)
    {
        $person = Person::find($id);
        $data = [
            'name' => $request->name,
            'cpf' => $request->cpf,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'email' => $request->email
        ];

        $person->update($data);
    }

    public function destroy($id){

        Person::find($id)->delete();
    }
}


