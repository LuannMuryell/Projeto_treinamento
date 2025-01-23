<?php

namespace App\Http\Requests;
use App\Rules\cpfRule;
use App\Rules\dateRule;
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

        $personId = $this->route('id');

        $rules = [
            'name' => 'required',
            'birth_date' => ['required', 'date', new dateRule(18)], 
            'gender' => 'required',
            'phone' => ['nullable','regex:/^\(\d{2}\) \d{5}-\d{4}$/'],
            'email' => ['nullable',
            'email:rfc,dns',
            'max:255',
            'unique:people,email' . 
            ($personId ? ",$personId" : '')] 
            //Para ignorar na edição.
        ];
        
    //Regra de validação para novos cadastros de CPF
        if(!$personId){
            $rules['cpf'] = ['required', 'unique:people,cpf', new cpfRule];
        }
        
        return $rules;
    }
    

    public function messages():array
    {
        return [
            'name.required' => 'Digite o nome',
            'birth_date.required' => 'Insira uma data de nascimento',
            'birth_date.date'=> 'Insira uma data de nascimento válida',
            'cpf.required' => 'Digite o CPF',
            'cpf.unique' => 'CPF já cadastrado',
            'cpfRule' => 'CPF inválido',
            'gender.required' => 'Selecione o seu gênero',
            'phone.regex' => 'O número deve estar em um formato válido: (99) 99999-9999',
            'email.email' => 'E-mail inválido',
            'email.unique' => 'E-mail já cadastrado'
        ];
    }
}

