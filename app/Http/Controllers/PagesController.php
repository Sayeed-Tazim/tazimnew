<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }
    public function service()
    {
        $data = array(
            'title' => 'Services Page',
            'services' => ['web design', 'graphic design', 'panta vat', 'daal muri', 'jhal muri']
        );
        return view('pages.service')->with($data);
    }
}
