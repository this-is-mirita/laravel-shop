<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        // TODO: Implement __invoke() method.
        //dump(auth()->user());
        return view('home');
    }
}
