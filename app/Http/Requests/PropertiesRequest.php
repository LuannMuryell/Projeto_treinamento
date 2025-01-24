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
            'area_terreno' => [new areaRule],
            'area_edificacao' => [new areaRule],
            'logradouro' => ['required','max:255'],
            'numero' => ['required', 'regex:/^\d+$/', 'max:10'],
            'bairro' => ['required','max:255'],
            'complemento' => ['nullable','max:255'],
            'contribuinte_id' => 'required'
        ];

        return $rules;

    }

    public function messages():array
    {
        return [
            'tipo.required' => 'Selecione o tipo de imóvel',
            'logradouro.required' => 'Informe o logradouro',
            'logradouro.max' => 'O campo logradouro não deve exceder 255 caracteres',
            'numero.required' => 'Informe o número',
            'numero.regex' => 'O campo número deve conter apenas números',
            'numero.max' => 'O campo número não deve exceder 10 caracteres',
            'bairro.required' => 'Informe o bairro',
            'bairro.max' => 'O campo bairro não deve exceder 255 caracteres',
            'contribuinte_id.required' => 'Selecione o contribuinte',
            'complemento.max' => 'O campo complemento não deve exceder 255 caracteres'
        ];
    }

// Para garantir que os valores enviados ao banco de dados sejam zero nos devidos campos abaixo ao selecionar um tipo de imóvel.
// Além disso, transforma vírgulas em pontos para não dar problemas no banco de dados. 
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
