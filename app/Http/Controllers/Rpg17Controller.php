<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Puja;
use App\Models\PujaData;

class Rpg17Controller extends Controller
{
    public function Rpg17(Request $request)
    {
        return view('rpg17.index')->with('request',$request);
    }
}
