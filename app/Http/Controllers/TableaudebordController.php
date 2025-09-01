<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TableaudebordController extends Controller
{

    public function index(){

        return view('tableaudebord.index');

    }

}
