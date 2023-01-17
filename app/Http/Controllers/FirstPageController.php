<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\LoginRequest;

class FirstPageController extends Controller
{
    public function index(){
        return view('fistPage');
    }
    public function email(Request $request){
        $request['email'] = trim($request['email']);
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email:rfc,dns']
        ]);
        if($validator->fails()){
            $request->flash();
            return back()->withErrors($validator)->withInput();
        }
        Mail::to('rugilestasionyte@gmail.com')->send(new LoginRequest($request->email));
        return redirect()->back()->with('message', 'Thank you, I will send you login data as soon as possible.');
    }
    
}
