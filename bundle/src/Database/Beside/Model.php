<?php

namespace Bundle\Database\Beside;

use Bundle\Contracts\Validation\Rules;
use JetBrains\PhpStorm\ArrayShape;

abstract class Model implements Rules
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_PASSWORD = 'password';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    //public const RULE_UNIQUE = 'unique';

    public array $errors = [];

    /**
     * It takes an array of data and assigns the values to the properties of the object.
     *
     * @param array $data
     */
    public function load(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * It loops through the rules for each attribute, and if the rule is not satisfied, it adds an error to the errors
     * array.
     */
    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                if (self::RULE_REQUIRED === $ruleName && !$value) {
                    $this->appendError($attribute, self::RULE_REQUIRED);
                }
                if (self::RULE_EMAIL === $ruleName && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->appendError($attribute, self::RULE_EMAIL);
                }
                if (self::RULE_MIN === $ruleName && strlen($value) < $rule['min']) {
                    $this->appendError($attribute, self::RULE_MIN, ['min' => $rule['min']]);
                }
                if (self::RULE_MAX === $ruleName && strlen($value) > $rule['max']) {
                    $this->appendError($attribute, self::RULE_MAX);
                }
                if (self::RULE_MATCH === $ruleName && $value !== $this->{$rule['match']}) {
                    $this->appendError($attribute, self::RULE_MATCH, ['match' => $rule['match']]);
                }
                /*if (self::RULE_UNIQUE === $ruleName) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $db = Application::$app->db;
                    $statement = $db->prepare("SELECT * FROM {$tableName} WHERE {$uniqueAttr} = :{$uniqueAttr}");
                    $statement->bindValue(":{$uniqueAttr}", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if ($record) {
                        $this->addErrorByRule($attribute, self::RULE_UNIQUE);
                    }
                }*/
            }
        }

        return empty($this->errors);
    }

    /**
     * It takes an attribute, a rule, and an array of parameters, and it appends an error message to the errors array.
     *
     * @param string $attribute
     * @param string $rule
     * @param mixed $params
     */
    public function appendError(string $attribute, string $rule, array $params = [])
    {
        $message = $this->message()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$attribute][] = $message;
    }

    /**
     * It checks if the attribute has an error.
     *
     * @param mixed $attribute
     * @return mixed
     */
    public function hasError(string $attribute): mixed
    {
        return $this->errors[$attribute] ?? false;
    }

    /**
     * It returns the first error message for the specified attribute.
     *
     * @param mixed $attribute
     *
     * @return string first error message for the attribute
     */
    public function getErrorMessage(string $attribute): string
    {
        return $this->errors[$attribute][0] ?? false;
    }

    /**
     * It returns an array of messages that will be used to display error messages to the user.
     *
     * @return array of messages
     */
    #[ArrayShape([self::RULE_REQUIRED => "string", self::RULE_EMAIL => "string", self::RULE_MIN => "string", self::RULE_MAX => "string"])]
    public function message(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required.',
            self::RULE_EMAIL => 'This field must be valid email',
            self::RULE_MIN => 'Min Length of the field must be {min}',
            self::RULE_MAX => 'Min Length of the field must be {max}',
        ];
    }
}
