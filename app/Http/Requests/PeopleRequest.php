<?php

namespace App\Http\Requests;
use App\Rules\cpfRule;
use App\Rules\phoneRule;
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
            'name' => ['required','max:255'],
            'birth_date' => ['required', 'date', new dateRule(18)], 
            'gender' => 'required',
            'phone' => ['nullable', new phoneRule],
            'email' => ['nullable',
            'email:rfc,dns',
            'max:255',
            'unique:people,email' . 
            ($personId ? ",$personId" : '')] 
            // Para ignorar o mesmo e-mail na edição
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
            'name.max' => 'O campo nome não deve exceder 255 caracteres',
            'birth_date.required' => 'Insira uma data de nascimento',
            'birth_date.date'=> 'Insira uma data de nascimento válida',
            'cpf.required' => 'Digite o CPF',
            'cpf.unique' => 'CPF já cadastrado',
            'gender.required' => 'Selecione o seu gênero',
            'email.email' => 'E-mail inválido',
            'email.unique' => 'E-mail já cadastrado',
            'email.max' => 'O campo e-mail não deve exceder 255 caracteres'
        ];
    }
    // Adicionei essa função para limpar os dados no banco de dados retirando caracteres especiais
    protected function prepareForValidation()
    {
        $this->merge([
            'cpf' => preg_replace('/\D/', '', $this->cpf),
            'phone' => preg_replace('/\D/', '', $this->phone),
        ]);
    }
}

