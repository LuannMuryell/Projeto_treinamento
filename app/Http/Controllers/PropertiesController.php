<?php

namespace App\Http\Controllers;
use App\Models\Property;
use App\Models\Person;
use App\Models\Averbacao;
use App\Models\File;
use App\Http\Requests\PropertiesRequest;
use App\Http\Requests\FilesRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

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
            
    public function store(PropertiesRequest $request)
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
        
       $property = Property::create($data);

         if($property && $request->hasFile('files')){
            foreach ($request->file('files') as $file){
                $storagePath = $file->store('properties_files', 'public');

                File::create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $storagePath,
                    'file_ins_municipal' => $property->ins_municipal,
                ]);
            }
        }
    }
    

    public function edit(string $ins_municipal){
       
        $property = Property::find($ins_municipal);

        $files = File::where('file_ins_municipal', $ins_municipal)->get();

        $averbacao = Averbacao::where('property_id', $ins_municipal)->first();

        $people = Person::select('id', 'name')->get();
        return Inertia::render('Properties/EditProperties', ['property' => $property, 'people' => $people, 'files'=>$files, 'averbacao' => $averbacao]);
    }

    public function update(PropertiesRequest $request, string $ins_municipal)
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

        if($request->hasFile('files')){
            foreach ($request->file('files') as $file){
                $storagePath = $file->store('properties_files', 'public');

                File::create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $storagePath,
                    'file_ins_municipal' => $property->ins_municipal,
                ]);
            }
        }
    }

    public function destroy($ins_municipal){

        Property::find($ins_municipal)->delete();
    }

    public function uploadFile(FilesRequest $request, $file_ins_municipal){
        if($request->hasFile('files')){
            foreach ($request->file('files') as $file){
                $storagePath = $file->store('properties_files', 'public');

                File::create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $storagePath,
                    'file_ins_municipal' => $file_ins_municipal,
                ]);
            }
        }
    }

    public function destroyFile(string $id) 
    {
        File::destroy($id);
    }

    public function downloadFile(string $id){
        $file = File::find($id);
        return Storage::download($file->file_path, $file->file_name);
    }

}

