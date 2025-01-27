<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilesRequest extends FormRequest
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
            'files' => ['nullabe', 'array', 'max:5'],
            'files.*' => ['file', 'mimes:jpg,jpeg,png,pdf','max:3072']
        ];
    }

    public function messages(): array
    {
        return [
            'files.max' => 'Você pode anexar no máximo 5 arquivos',
            'files.*.file' => 'Insira um arquivo válido',
            'files.*.mimes' => 'Os formatos permitidos são: .jpg, .jpeg, .png e .pdf',
            'files.*.max' => 'Cada arquivo não deve exceder o tamanho máximo de 3MB'
        ];
    }
}
