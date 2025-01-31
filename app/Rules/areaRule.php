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
        if (preg_match('/\.\d{3,}/', $value)) {
            $fail("O campo não deve exceder duas casas decimais");
        }

        $area_terreno = request()->input('area_terreno');

        if ($area_terreno && $value > $area_terreno) {
            $fail('A área da edificação não pode ser maior que a área do terreno');
        }

    }
}
