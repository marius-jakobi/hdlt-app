<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Week implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Check if week string is a valid week like "2020-W45"
        return strtotime($value) != false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Ungültige Kalenderwoche';
    }
}
