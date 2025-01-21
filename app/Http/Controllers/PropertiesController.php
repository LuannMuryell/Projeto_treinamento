<?php

namespace App\Http\Controllers;
use App\Models\Property;
use App\Models\Person;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PropertiesController extends Controller
{
    public function index(){
        $properties = Property::with('contribuinte')->get();
        return Inertia::render('Properties/Properties', ['properties' => $properties]);
    }

    public function create() {

        $people = Person::select('id', 'name')->get();

        return Inertia::render('Properties/RegisterProperties', ['people' => $people]);
    }
            
    public function store(Request $request)
    {
        $data = [
            'tipo' => $request->tipo,
            'area_terreno' => $request->area_terreno,
            'area_edificacao' => $request->area_edificacao,
            'logradouro' => $request->logradouro,
            'numero' => $request->numero,
            'bairro' => $request->bairro,
            'complemento' => $request->complemento,
            'contribuinte_id' => $request->contribuinte_id,
        ];

        Property::create($data);
    }

    public function edit(string $ins_municipal){

        $property = Property::find($ins_municipal);
        $people = Person::select('id', 'name')->get();
        return Inertia::render('Properties/EditProperties', ['property' => $property, 'people' => $people]);
    }

    public function update(Request $request, string $ins_municipal)
    {
        $property = Property::find($ins_municipal);
        $data = [
            'tipo' => $request->tipo,
            'area_terreno' => $request->area_terreno,
            'area_edificacao' => $request->area_edificacao,
            'logradouro' => $request->logradouro,
            'numero' => $request->numero,
            'bairro' => $request->bairro,
            'complemento' => $request->complemento,
            'contribuinte_id' => $request->contribuinte_id,
            'situacao' => $request->situacao
        ];

        $property->update($data);
    }

    public function destroy($ins_municipal){

        Property::find($ins_municipal)->delete();
    }
}

