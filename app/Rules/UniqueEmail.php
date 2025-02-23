<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueEmail implements ValidationRule
{
    private $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $emailExist = DB::table('users')
            ->where('email', '=', $value)
            ->where("id", "!=", $this->userId)
            ->exists();

        if ($emailExist) {
            $fail("Email has already taken");
        }
    }
}
