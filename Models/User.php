<?php

namespace App\Models;

use App\Core\Database\Beside\Model;

class User extends Model
{
    public string $email = '';

    public string $password = '';

    /**
     * > The function `register()` returns the string `"user is creating."`.
     *
     * @return string string
     */
    public function register(): string
    {
        return 'user is creating.';
    }

    /**
     * > The `rules()` function returns an array of rules that are used to validate the form.
     *
     * @return array of rules
     */
    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, self::RULE_PASSWORD, [self::RULE_MIN, 'min' => 4]],
        ];
    }
}
