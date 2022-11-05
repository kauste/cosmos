<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Mine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{

    public function index()
    {
        $title = 'Cosmos countries';
        $countries = Country::orderBy('country_name')->get();
        return view('countries.list', ['title '=> $title, 
                                        'countries'=> $countries,]);
    }
    public function create()
    {
        $title = 'Cosmos create';
        return view('countries.create', ['title '=> $title,]);
    }
    public function store(Request $request)
    {

        $request['country-name'] = trim($request['country-name']);
        $validator = Validator::make($request->all(), [
            'country-name' => ['required', 'min:3','max:50', 'unique:countries,country_name'],
            'max-amount' => ['required', 'integer','min:1','max:50'],
        ]);
        
        // validateWithBag('msg');
    
        // $validator->after(function($validator) use ($variable){
        //     if (fn()) {
        //         $validator->errors()->add('msg','Country cannot be included!'); 
        //     }
        // });

        if($validator->fails()){
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }

        $country = new Country;
        $country->country_name = $request['country-name'];  
        $country->amount_of_mines = $request['max-amount'];
        $country->save();

        return redirect()->route('country-list')->with('message', 'Country is added');
    }
    public function show(Country $country)
    {
        //
    }

    public function edit(Country $country)
    {
        $maxMinesInCountry = $country->amount_of_mines;
        $minesNowInCountry = Mine::where('country_id', '=', $country->id)->count();
        
        $title = 'Cosmos edit';
        return view('countries.edit', ['title '=> $title,
                                        'country'=> $country,
                                        'isMaxMines' => $maxMinesInCountry = $minesNowInCountry ? 1 : 0
                                      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCountryRequest  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {

        $validator = Validator::make($request->all(), [
            'max-amount' => ['required', 'integer','min:1','max:50'],
        ]);
        if($validator->fails()){
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }
        $country->amount_of_mines = $request['max-amount'];
        $country->save();

        return redirect()->route('country-list')->with('message', 'Country info is edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->back()->with('message', $country->country_name.' is deteted');
    }
}
