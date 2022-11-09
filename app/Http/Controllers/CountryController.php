<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Mine;
use App\Models\Ship;
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
        $mines = Mine::where('country_id', '=', null)->get();
        $ships = Ship::where('country_id', '=', null)->get();
        return view('countries.create', ['title '=> $title,
                                        'mines' => $mines,
                                        'ships'=> $ships]);
    }
    public function store(Request $request)
    {
        $request['country-name'] = trim($request['country-name']);
        $validator = Validator::make($request->all(), [
            'country-name' => ['required', 'min:3','max:50', 'unique:countries,country_name'],
            'max-amount' => ['required', 'integer','min:1','max:50'],
            'add-mine' => ['array', 'max:'.$request['max-amount']],
        ],
        [
            'add-mine.max' => 'Chosen maximum amount of mines is smaller then amount of mines you chose.'
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

        if($request['add-mine']){
            Mine::whereIn('id', $request['add-mine'])->update(['country_id'=> $country->id]);
        }
        if($request['add-ship']){
            Ship::whereIn('id', $request['add-ship'])->update(['country_id'=> $country->id]);
        }
      
        if($request['add-mine'] && $request['add-ship']){
            collect($request['add-mine'])->map(function($mineId) use ($request){
                Mine::find($mineId)->ships()->attach($request['add-ship']);
            });
            $msg = 'Country is added. By default all selected ships can go to all selected mines. In case you would like to configure it, go to preferable ships or mines and edit them.';
        }
        else {
            $msg = 'Country is added';
        }

        return redirect()->route('country-list')->with('message', $msg);
    }
    public function show(Country $country)
    {
        //
    }

    public function edit(Country $country)
    {
        $maxMinesInCountry = $country->amount_of_mines;
        $minesNowInCountry = Mine::where('country_id', '=', $country->id)->count();
        $mines = Mine::where('country_id', '=', null)->get();
        $ships = Ship::where('country_id', '=', null)->get();
        return view('countries.edit', ['title '=> 'Cosmos edit',
                                        'country'=> $country,
                                        'isMaxMines' => $maxMinesInCountry < $minesNowInCountry ? 1 : 0,
                                        'minesNowInCountry' => $minesNowInCountry,
                                        'availibleMines' => $mines,
                                        'ships' => $ships,
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
            'add-mine' => ['array']
        ]);
        if($validator->fails()){
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }
        $country->amount_of_mines = $request['max-amount'];
        $country->save();

        Mine::where('country_id', $country->id)->update(['country_id'=> null]);
        if($request['add-mine'] ){
            Mine::whereIn('id', $request['add-mine'])->update(['country_id'=> $country->id]);
        }
        if($request['add-ship']){
            Ship::whereIn('id', $request['add-ship'])->update(['country_id'=> $country->id]);
        }
      
        if($request['add-mine'] && $request['add-ship']){
            collect($request['add-mine'])->map(function($mineId) use ($request){
                Mine::find($mineId)->ships()->attach($request['add-ship']);
            });
            $msg = 'Country is added. By default all selected ships can go to all selected mines. In case you would like to configure it, go to preferable ships or mines and edit them.';
        }
        else {
            $msg = 'Country is added';
        }

        return redirect()->route('country-list')->with('message', $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        
        $minesIds = Mine::where('country_id', '=', $country->id)->select('id')->pluck('id')->all();
 
        collect($minesIds)->map(function($mineId){
            Mine::find($mineId)->ships()->detach();
        });

        Mine::where('country_id', $country->id)->update(['country_id'=> null]);
        Ship::where('country_id', $country->id)->update(['country_id'=> null]);

        $country->delete();
        return redirect()->back()->with('message', $country->country_name.' is deteted');
    }
}
