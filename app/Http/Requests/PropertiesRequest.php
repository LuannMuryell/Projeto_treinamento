<?php

namespace App\Http\Requests;
use App\Rules\areaRule;
use Illuminate\Foundation\Http\FormRequest;

class PropertiesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'tipo' => 'required',
            'logradouro' => ['required','max:255'],
            'numero' => ['required', 'numeric'],
            'bairro' => ['required','max:255'],
            'complemento' => ['nullable','max:255'],
            'contribuinte_id' => 'required'
        ];

        $tipo = $this->input('tipo');

        if($tipo === 'Terreno'){
            $rules['area_terreno'] = ['required','numeric','min:1', new areaRule];
        }elseif($tipo === 'Apartamento'){
            $rules['area_edificacao'] = ['required','numeric','min:1', new areaRule]; 
        }elseif($tipo === 'Casa'){
            $rules['area_terreno'] = ['required','numeric','min:1', new areaRule];
            $rules['area_edificacao'] = ['required','numeric','min:1', new areaRule]; 
        }
    
        return $rules;

    }

    public function messages():array
    {
        return [
            'tipo.required' => 'Selecione o tipo de imóvel',
            'logradouro.required' => 'Informe o logradouro',
            'logradouro.max' => 'O campo logradouro não deve exceder 255 caracteres',
            'numero.required' => 'Informe o número',
            'numero.numeric' => 'O campo número deve conter apenas números',
            'bairro.required' => 'Informe o bairro',
            'bairro.max' => 'O campo bairro não deve exceder 255 caracteres',
            'contribuinte_id.required' => 'Selecione o contribuinte',
            'complemento.max' => 'O campo complemento não deve exceder 255 caracteres',

            // Áreas
            'area_terreno.numeric' => 'O campo deve ser um número',
            'area_terreno.required' => 'Informe a área do terreno',
            'area_terreno.min' => 'A área do terreno deve ser maior que zero',
            'area_edificacao.numeric' => 'O campo deve ser um número',
            'area_edificacao.required' => 'Informe a área da edificação',
            'area_edificacao.min' => 'A área da edificação deve ser maior que zero'
        ];
    }

// Para garantir que os valores enviados ao banco de dados sejam zero nos devidos campos abaixo ao selecionar um tipo de imóvel.
// Além disso, transforma vírgulas em pontos para não dar problemas no banco de dados nos números decimais. 

    protected function prepareForValidation(): void
    {
        if ($this->tipo === 'Terreno') {
            $this->merge([
                'area_edificacao' => 0,
                'area_terreno' => str_replace(',', '.', $this->area_terreno)
            ]);
        }elseif ($this->tipo === 'Apartamento') {
            $this->merge([
                'area_terreno' => 0,
                'area_edificacao' => str_replace(',', '.', $this->area_edificacao)
            ]);
        }elseif ($this->tipo === 'Casa') {
            $this->merge([
               'area_terreno' => str_replace(',', '.', $this->area_terreno),
                'area_edificacao' => str_replace(',', '.', $this->area_edificacao)
            ]);
        }
    }
}
