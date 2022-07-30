<?php

namespace App\Http\Controllers;

use App\Core\Routing\Controller;
use App\Core\Http\Request;

/* The class `SiteController` is extending the class `Controller`. */
class SiteController extends Controller
{
    /**
     * The function `contact()` returns the view `contact` with the parameter `name` set to `Knights Framework`
     *
     * @return The view method is being called on the controller class.
     * The view method is a method that is defined in the controller class.
     * The view method is being passed two parameters. The first parameter is the name of the view file.
     * The second parameter is an array of data that will be passed to the view file.
     */
    public function contact(): The
    {
        $params = [
            'name' => 'Knights Framework'
        ];
        return $this->view('contact', $params);
    }

    /**
     * The function takes a request object as an argument, and returns a string
     *
     * @param Request request The request object.
     *
     * @return A string
     */
    public function handle(Request $request): string|A
    {
        $request = $request->all();
        var_dump($request);
        return 'Handling submited data';
    }
}
