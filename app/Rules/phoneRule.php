<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class phoneRule implements ValidationRule
{
// Adicionei uma lista com todos os DDDs do Brasil
    protected $allDDD = [
        '11', '12', '13', '14', '15', '16', '17', '18', '19', '21', '22', '23', '24', '27', '28', '31', '32', '33', '34', '35', '37', '38', '41', '42', '43', '44', '45', '46', '47', '48', '49', '51', '53', '54', '55', '61', '62', '63', '64', '65', '66', '67', '68', '69', '71', '73', '74', '75', '77', '79', '81', '82', '83', '84', '85', '86', '87', '88', '89', '91', '92', '93', '94', '95', '96', '97', '98', '99'
    ];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(strlen($value) != 11){
            $fail('O número de celular não está completo');
            return;
        }

        $phoneDDD = substr($value, 0, 2);

        if(!in_array($phoneDDD, $this->allDDD)){
            $fail('O DDD informado é inválido');
            return;
        }

        if(substr($value, 2, 1) != 9){
            $fail('O número de celular deve iniciar com 9');
            return;
        }
    }
}
