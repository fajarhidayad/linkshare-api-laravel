<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueUsername implements ValidationRule
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
        $usernameExist = User::where("username", $value)
            ->where("id", "!=", $this->userId)
            ->exists();

        if ($usernameExist) {
            $fail("Username has already taken");
        }
    }
}
