<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\Country;
use App\Models\Mine;
use App\Models\Ship;
use App\Models\Alliance;
use Auth;

class CountryController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $countries = Country::orderBy('country_name')->get()
                    ->map(function($country){
                        $country->allianceCountries = $country->alliance?->countries()->get()
                        ->map(function($allianceCountry){
                            $allianceCountry->allianceShips  = $allianceCountry->ships()->get();
                            $allianceCountry->allianceMines  = $allianceCountry->mines()->get();
                            return $allianceCountry;
                        });
                        return $country;
                    });

// $cntr = Alliance::where('id','=', 1)->get()
//         ->map(function($aliance) {
//             $aliance->country = $aliance->countries()->get()
//             ->map(function($country) {
//                 $country->ships = $country->ships()->get();
//                 return $country;
//             });
//             return $aliance;
//         });
        return view('countries.list', ['title '=> 'Cosmos countries', 
                                        'countries'=> $countries,
                                        'allianceShips' => '']);
    }
    public function create(Request $request)
    {
        $old = $request->old() != [] ? $request->old() : null;
        $alliances = Alliance::all();
        $mines = Mine::where('country_id', '=', null)->get();
        $ships = Ship::where('country_id', '=', null)->get();
        return view('countries.create', ['title '=> 'Cosmos create',
                                        'alliances'=> $alliances,
                                        'mines' => $mines,
                                        'ships'=> $ships,
                                        'old' => $old,
                                         ]);
    }
    public function store(Request $request)
    {
        $request['country-name'] = trim($request['country-name']);
        $validator = Validator::make($request->all(), [
            'country-name' => ['required', 'min:3','max:50', 'unique:countries,country_name'],
            'alliance' => ['nullable','exists:alliances,id'],
            'max-amount' => ['required', 'integer','min:1','max:50'],
            'add-mine' => ['array', 'max:'.$request['max-amount']],
        ],
        [
            'add-mine.max' => 'Chosen maximum amount of mines is smaller then amount of mines you chose.'
        ]);


        $getCountryName = Http::get('https://restcountries.com/v3.1/name/'.$request['country-name'], [
            'fields' => 'name'
        ]);

        $countryName = str_replace(' ', '-', $request['country-name']);
        $getStateName = Http::get('https://datausa.io/profile/geo/'.$countryName);
        // dd($request['country-name']);
        $validator->after(function($validator) use ($getCountryName, $getStateName){
            if ($getCountryName->failed() && $getStateName->failed()) {
                $validator->errors()->add('error','Error, cannot add this country.'); 
            }
        });

        if($validator->fails()){
            $request->flash();
            return back()->withErrors($validator)->withInput();
        }

        $country = new Country;
        $country->country_name = $request['country-name'];
        $country->alliance_id = $request['alliance'];    
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
        $alliances = Alliance::all();
        $mines = Mine::where('country_id', '=', null)->get();
        $ships = Ship::where('country_id', '=', null)->get();
        return view('countries.edit', ['title '=> 'Cosmos edit',
                                        'country'=> $country,
                                        'isMaxMines' => $maxMinesInCountry < $minesNowInCountry ? 1 : 0,
                                        'minesNowInCountry' => $minesNowInCountry,
                                        'alliances'=> $alliances,
                                        'availibleMines' => $mines,
                                        'ships' => $ships,
                                      ]);
    }

    public function update(Request $request, Country $country)
    {
        $validator = Validator::make($request->all(), [
            'max-amount' => ['required', 'integer','min:1','max:50'],
            'alliance' => ['nullable','exists:alliances,id'],
            'add-mine' => ['array']
        ]);
        
        if($validator->fails()){
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }
        $country->amount_of_mines = $request['max-amount'];
        $country->alliance_id = $request['alliance']; 
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
                Mine::find($mineId)->ships()->detach();
                Mine::find($mineId)->ships()->attach($request['add-ship']);
            });
            $msg = 'Country is edited. By default all selected ships can go to all selected mines. In case you would like to configure it, go to preferable ships or mines and edit them.';
        }
        else {
            $msg = 'Country is edited';
        }

        return redirect()->route('country-list')->with('message', $msg);
    }

    public function destroy(Country $country)
    {
        if(Country::where('id', $country->id)->first() == null || !(int) $country->id){
            return redirect()->route('country-list')->with('message', 'Something went wrong. Country is not identified.');
        }

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
