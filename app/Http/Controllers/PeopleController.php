<?php

namespace App\Http\Controllers;
use App\Http\Requests\PeopleRequest;
use App\Models\Person;
use Inertia\Inertia;

class PeopleController extends Controller
{
    public function index(){
        $people = Person::paginate(10);
        return Inertia::render('People/People', ['people' => $people]);
    }

    public function create(){
        return Inertia::render('People/RegisterPeople');
    }

    public function store(PeopleRequest $request)
    {
        $data = [
            'name' => $request->name,
            'cpf' => $request->cpf,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'email' => $request->email,
        ];

        Person::create($data);
    }

    public function edit(string $id){

        $person = Person::find($id);

        return Inertia::render('People/EditPeople', ['person' => $person]);
    }

    public function update(PeopleRequest $request, string $id)
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


