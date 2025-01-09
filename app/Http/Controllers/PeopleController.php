<?php

namespace App\Http\Controllers;
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
}


