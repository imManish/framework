<?php

namespace App\Core\Contracts\Form;

use App\Core\Database\Beside\Model;

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
     * @return string
     */
    public static function end()
    {
        echo '</form>';
    }

    /**
     * > It returns a new instance of the `Fields` class, passing the model and attribute to the constructor.
     *
     * @param Model model The model that the field is being generated for
     * @param attribute the name of the attribute to be used
     * @param mixed $attribute
     *
     * @return Fields a new instance of the Fields class
     */
    public function field(Model $model, $attribute): Fields
    {
        return new Fields($model, $attribute);
    }
}
