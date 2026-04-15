<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Filters\LdonFilter;

class LdonController extends Controller
{
    public function index(Request $request)
    {
        $ldonPlayers = (new LdonFilter($request))->apply()->paginate(50);

        return view('ldon.index', compact('ldonPlayers'));
    }
}
