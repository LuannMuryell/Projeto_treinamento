<?php

namespace App\Http\Requests;
use App\Rules\areaRule;
use Illuminate\Foundation\Http\FormRequest;

class AverbacoesRequest extends FormRequest
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
            'evento' => ['required'],
            'descricao' => ['required','max:255'],
            'property_id' => ['required']
        ];

        $evento = $this->input('evento');

        if($evento === 'Aumento de Área Construída'){
            $rules['medida'] = ['required','numeric','min:1', new areaRule];
        }elseif($evento === 'Redução de Área Construída'){
            $rules['medida'] = ['required','numeric','min:1', new areaRule]; 
        }else{
            $rules['medida'] = ['nullable'];
        }

        return $rules;
    }

    public function messages():array
    {
        return [
            'evento.required' => 'Selecione o Evento',
            'descricao.required' => 'O campo descrição é obrigatório',
            'descricao.max' => 'O campo descrição não deve exceder 255 caracteres',
            'medida.numeric' => 'O campo medida deve ser um número',
            'medida.required' => 'O campo medida é obrigatório',
            'medida.min' => 'A medida deve ser maior que zero'
        ];
    }

    protected function prepareForValidation(): void
    {
        $evento = $this->input('evento');

        if ($evento === 'Aumento de Área Construída') {
            $this->merge([
                'medida' => str_replace(',', '.', $this->medida)
            ]);
        }elseif($evento === 'Redução de Área Construída') {
            $this->merge([
                'medida' => str_replace(',', '.', $this->medida)
            ]);
        }
    }
}
