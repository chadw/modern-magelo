<?php

namespace App\Http\Controllers;

use App\Models\Flag;
use Illuminate\Http\Request;

class FlagController extends Controller
{
    public function index()
    {
        $flags = Flag::where('charid', 1)
            ->select('name', 'value')
            ->get();

        //return response()->json($guild);
        return view('flags', ['flags' => $flags]);
    }
}
