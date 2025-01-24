<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DateRule implements ValidationRule
{
    protected $age;

    public function __construct($age = 18)
    {
        $this->age = $age;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $birth_date = strtotime($value);
        $currentDate = strtotime(date('Y-m-d'));

        // Para calcular a idade:
        $age = date('Y', $currentDate) - date('Y', $birth_date);
        if (date('m-d', $currentDate) < date('m-d', $birth_date)) {
            $age--;
        }

        if ($age < $this->age) {
            $fail("Idade mínima permitida: 18 anos");
        }
    }
}
