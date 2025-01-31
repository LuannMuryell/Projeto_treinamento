<?php

namespace App\Http\Controllers;
use App\Models\Property;
use App\Models\Averbacao;
use App\Http\Requests\AverbacoesRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AverbacoesController extends Controller
{
    public function index($ins_municipal) {
        // Buscando o imóvel pelo ins_municipal
        $property = Property::where('ins_municipal', $ins_municipal)->first();

        // Lógica para buscar todas as averbações associadas a esse imóvel
        $averbacoes = Averbacao::where('property_id', $property->ins_municipal)->get();

        return Inertia::render('Properties/Averbações/ShowAverbacoes', ['averbacoes' => $averbacoes, 'property' => $property
        ]);
    }
    

    public function create($ins_municipal){
        $property = Property::find($ins_municipal);
        return Inertia::render('Properties/Averbações/RegisterAverbacoes', ['property' => $property]);
    }

    public function store(AverbacoesRequest $request){

        $property = Property::where('ins_municipal', $request->property_id)->first();

        $data = [
            'evento' => $request->evento,
            'descricao' => $request->descricao,
            'medida'=> $request->medida,
            'data_averbacao' => now(),
            'property_id' => $request->property_id
        ];

        Averbacao::create($data);

        // Seção de regras para alterar os dados dos Imóveis 

        // Criando variáveis para chamar alguns campos do banco de dados dos Imóveis
        $evento = $request->input('evento');
        $medida = $request->input('medida');
        $areaAtual = $property->area_edificacao;
        $areaTerreno = $property->area_terreno;
        $tipoImovel = $property->tipo;
        $alterarSituacao = $property->situacao;

        // Alterando a situação do Imóvel para 'Inativo'
        if($evento === 'Cancelamento'){
            if($alterarSituacao === 'Inativo'){
                throw ValidationException::withMessages([
                    'evento' => "Não é possível desativar um imóvel que já se encontra 'Inativo'"
                ]);
            }
            $property->update(['situacao' => 'Inativo']);

        // Alterando a situação do Imóvel para 'Ativo'
        }else if($evento === 'Reativação'){
            if($alterarSituacao === 'Ativo'){
                throw ValidationException::withMessages([
                    'evento' => "Não é possível reativar um imóvel que já se encontra 'Ativo'"
                ]);
            }
            $property->update(['situacao' => 'Ativo']);
        }

        // Validação para que não permita alterar a área da edificação em um terreno que supostamente não deveria haver edificações
        if ($evento === 'Aumento de Área Construída' || $evento === 'Redução de Área Construída') {
            if ($tipoImovel === 'Terreno') {
                throw ValidationException::withMessages([
                    'medida' => "Não é permitido alterar a área construída para imóveis do tipo 'Terreno'"
                ]);
            }

        // Lógica para aumentar ou reduzir a área da edificação 
        // E também uma validação para impedir que a área da edificação não exceda a área total do terreno
        if ($evento === 'Aumento de Área Construída') {
            $newArea = $areaAtual + $medida;
                if($newArea > $areaTerreno){
                    throw ValidationException::withMessages([
                        'medida' => "A nova área construída ({$newArea} m²) não deve exceder a área total do terreno ({$areaTerreno} m²)"
                ]);
            }
        } elseif ($evento === 'Redução de Área Construída') {
            if ($areaAtual - $medida < 0) {
                $newArea = 0;
            } else {
                $newArea = $areaAtual - $medida;
            }
            } else {
                $newArea = $areaAtual;
            }
        $property->update(['area_edificacao' => $newArea]);
        }
    }
}

