<?php

namespace App\Core\Contracts\Form;

use App\Core\Database\Beside\Model;

// A class that is used to create a form field.
class Fields
{
    // A constant that is used to set the type of the field to text.
    public const TYPE_TEXT = 'text';

    // A constant that is used to set the type of the field to password.
    public const TYPE_PASSWORD = 'password';

    // A constant that is used to set the type of the field to number.
    public const TYPE_NUMBER = 'number';

    // A constant that is used to set the type of the field to email.
    public const TYPE_EMAIL = 'email';

    // A property of the class.
    public Model $model;

    // A property of the class.
    public string $attribute;

    // A property of the class.
    public string $type;

    /**
     * This function is a constructor for the class `Attribute`.
     *
     * @param Model model The model that the field is attached to
     * @param string attribute The name of the attribute to be displayed
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->type = self::TYPE_TEXT;
        $this->model = $model;
        $this->attribute = $attribute;
    }

    /**
     * > The `__toString()` function is called when the object is used in a string context.
     *
     * @return string the formGroup() method
     */
    public function __toString(): string
    {
        return $this->formGroup();
    }

    /**
     * It sets the type of the field to password.
     *
     * @return The object itself
     */
    public function passwordFiled(): object
    {
        $this->type = self::TYPE_PASSWORD;

        return $this;
    }

    /**
     * It sets the type of the field to email.
     *
     * @return The object itself
     */
    public function emailField(): object
    {
        $this->type = self::TYPE_EMAIL;

        return $this;
    }

    /**
     * It returns a string that contains a form group with a label, input, and error message.
     *
     * @return string string of HTML code
     */
    private function formGroup(): string
    {
        return sprintf(
            '
        <div class="form-group mb-6">
            <label class="form-label inline-block mb-2 text-gray-700">%s</label>
            <input type="%s" name="%s" value="%s" class="form-control block w-full px-3 py-1.5 text-base font-normal
        text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0
        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-describedby="emailHelp" 
        placeholder="%s"><small class="%s peer-invalid:visible text-red-700 font-light">%s</small>
        <small class="block mt-1 text-xs text-gray-600">%s</small>
        </div>',
            ucfirst($this->attribute),
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            'Enter '.ucfirst($this->attribute),
            $this->model->hasError($this->attribute) ? 'is-invalid' : 'invisible',
            $this->model->getErrorMessage($this->attribute),
            ('email' == $this->attribute) ? "We'll never share your email with anyoneelse." : ''
        );
    }
}
