<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class NotSelf implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if ($value === auth()->user()->email) {
            $fail('Cannot use your own email for :attribute');
        }
    }
}
