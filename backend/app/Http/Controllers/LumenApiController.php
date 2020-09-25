<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LumenApiController extends Controller
{
    public function requestAsanFinance(Request $request){

        $res = Http::get('http://localhost/lumen/public/api/asanfinance');

        if ($request->expectsJson())
            return $res;
        else return view('is\asanfinance')->with('query', $res);

    }
}
