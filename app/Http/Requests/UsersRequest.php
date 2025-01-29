<?php

namespace App\Http\Requests;

use App\Rules\cpfRule;
use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
        $userId = $this->route('id');

        $rules = [
            'name' => ['required'],
            'email' => ['required', 
            'email:rfc,dns', 
            "unique:users,email,{$userId},id"],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => ['required'],
            'profile' => ['required']
        ];

        if (!$userId) {
            $rules['cpf'] = ['required', 'unique:users,cpf', new cpfRule];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Digite o nome',
            'cpf.required' => 'Digite o CPF',
            'cpf.unique' => 'CPF já cadastrado',
            'password.required' => 'Registre uma senha',
            'password.confirmed' => 'As senhas devem ser iguais',
            'password_confirmation.required' => 'Confirme a senha',
            'email.required' => 'Digite o e-mail',
            'email.email' => 'E-mail inválido',
            'email.unique' => 'E-mail já cadastrado',
            'profile.required' => 'Selecione o perfil',
            'profile.in' => 'Perfil inválido. Escolha entre Administrador da TI (T), Administrador do Sistema (S) ou Atendente (A)',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            // Remove caracteres não numéricos do CPF
            'cpf' => $this->cpf ? preg_replace('/\D/', '', $this->cpf) : null,
        ]);
    }
}
