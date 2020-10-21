<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    function index(){
        return view('welcome');
    }
    function test(){
        return response()->json([
            'msg'=> 'error message'
        ],422);
    }
}
