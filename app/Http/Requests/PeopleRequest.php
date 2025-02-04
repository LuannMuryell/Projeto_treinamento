<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeopleRequest extends FormRequest
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
        return [
            'name' => 'required',
            'cpf' => 'required',
            'birth_date' => 'required|date',
            'gender' => 'required'
        ];
    }

    public function messages():array
    {
        return [
            'name.required' => 'Digite o nome',
            'birth_date.required' => 'Insira uma data de nascimento',
            'birth_date.date'=> 'Insira uma data de nascimento válida',
            'cpf.required' => 'Digite o CPF',
            'gender.required' => 'Selecione o seu gênero'
        ];
    }
}

