<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FirstPageController extends Controller
{
    public function index(){
        return view('fistPage');
    }
    public function emile(Request $request){
        // dump($request->email);

        return redirect()->back()->with('message', 'Thank you, I will send you login data as soon as possible.');
    }
    
}
