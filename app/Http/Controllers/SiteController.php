<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{

    public function index(){
        // echo "Ola";
        return view('site.home');
    }
    //
}
