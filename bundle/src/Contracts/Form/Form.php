<?php

namespace Bundle\Contracts\Form;

use Bundle\Database\Beside\Model;

class Form
{
    /**
     * This used to create dynamic form.
     *
     * @param $action
     * @param $method
     *
     * @return Form|string
     */
    public static function begin($action, $method): Form|string
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);

        return new Form();
    }


    /**
     * It prints the closing form tag
     */
    public static function end(): void
    {
        echo '</form>';
    }

    /**
     * > It returns a new instance of the `Fields` class, passing the model and attribute to the constructor.
     *
     * @param Model $model
     * @param mixed $attribute
     *
     * @return Fields a new instance of the Fields class
     */
    public function field(Model $model, $attribute): Fields
    {
        return new Fields($model, $attribute);
    }
}
