<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class areaRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if (strlen(preg_replace('/\D/', '', $value)) > 10) {
            $fail("O campo não deve exceder 10 dígitos");
        }

        if (preg_match('/\.\d{3,}/', $value)) {
            $fail("O campo não deve exceder duas casas decimais");
        }

        // Sequência de regras que impedem que seja enviado alguma área de terreno ou edificação de acordo com o tipo de imóvel selecionado

        $tipo = request()->input('tipo');

        if ($tipo === 'Terreno') {
            if ($attribute === 'area_terreno' && $value <= 0) {
                $fail('Informe a área do terreno');
            } elseif ($attribute === 'area_edificacao' && $value != 0) {
                $fail('A área da edificação deve ser zero para terrenos');
            }
        } elseif ($tipo === 'Casa') {
            if ($attribute === 'area_terreno' && $value <= 0) {
                $fail('Informe a área do terreno');
            } elseif ($attribute === 'area_edificacao' && $value <= 0) {
                $fail('Informe a área da edificação');
            }
        } elseif ($tipo === 'Apartamento') {
            if ($attribute === 'area_terreno' && $value != 0) {
                $fail('A área do Terreno deve ser zero para apartamentos');
            } elseif ($attribute === 'area_edificacao' && $value <= 0) {
                $fail('Informe a área da edificação');
            }
        } else {
            $fail('Para inserir as aréas, selecione o tipo de imóvel.');
        }
    }
}
