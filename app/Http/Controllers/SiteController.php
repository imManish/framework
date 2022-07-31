<?php

namespace App\Http\Controllers;

use Bundle\Http\Request;
use Bundle\Routing\Controller;

/* The class `SiteController` is extending the class `Controller`. */
class SiteController extends Controller
{
    /**
     * The function `contact()` returns the view `contact` with the parameter `name` set to `Knights Framework`
     *
     * @return string The view method is being called on the controller class.
     * The view method is a method that is defined in the controller class.
     * The view method is being passed two parameters. The first parameter is the name of the view file.
     * The second parameter is an array of data that will be passed to the view file.
     */
    public function contact(): string
    {
        $params = [
            'name' => 'Knights Framework'
        ];
        return $this->view('contact', $params);
    }

    /**
     * The function takes a request object as an argument, and returns a string
     *
     * @param Request $request
     * @return string
     */
    public function handle(Request $request): string
    {
        $request = $request->all();
        var_dump($request);
        return 'Handling submited data';
    }
}
