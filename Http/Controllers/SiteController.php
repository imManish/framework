<?php
namespace App\Http\Controllers;

use App\Core\Controller;
use App\Core\Request;

class SiteController extends Controller
{
    public function contact()
    {
        $params = [
            'name' => 'Knights Framework'
        ];
        return $this->view('contact', $params);
    }

    public function handle(Request $request)
    {
        $request = $request->all();
        var_dump($request);
        return 'Handling submited data';
    }
}