<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rifa;

class SiteController extends Controller
{

    public function index(){
        $rifaAtiva = new Rifa();
        $rifaEncerrada = new Rifa();
        $rifaAtiva = $rifaAtiva->rifasAtivas();
        $rifaEncerrada = $rifaEncerrada->rifasEncerradas();
        return view('site.home',compact('rifaAtiva','rifaEncerrada'));
    }
    public function regulamento(){
        $a = "";
        // $rifaAtiva = new Rifa();
        // $rifaEncerrada = new Rifa();
        // $rifaAtiva = $rifaAtiva->rifasAtivas();
        // $rifaEncerrada = $rifaEncerrada->rifasEncerradas();
        return view('site.regulamento',compact('a',));
    }
    public function termos(){
        $a = "";
        // $rifaAtiva = new Rifa();
        // $rifaEncerrada = new Rifa();
        // $rifaAtiva = $rifaAtiva->rifasAtivas();
        // $rifaEncerrada = $rifaEncerrada->rifasEncerradas();
        return view('site.termos',compact('a',));
    }
    //
}
