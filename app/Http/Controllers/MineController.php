<?php

namespace App\Http\Controllers;

use App\Models\Mine;
use App\Models\Country;
use App\Models\Ship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use DB;

class MineController extends Controller
{
    public function index()
    {

        $mines = Mine::orderBy('mine_name')->get()
                ->map(function($mine){

                    $mine->allianceCountries = $mine->country?->alliance?->countries
                        ->map(function($allianceCountry){
                            $allianceCountry->allianceShips = $allianceCountry->ships;
                            return $allianceCountry;
                        });
                        return $mine;
                });
        return view('mines.list', ['title' => 'List of mines',
                                   'mines' => $mines]);
    }

    public function create(Request $request, $country = null)
    {
        $cntr = Country::where('id',$country)->first();
        $old = $request->old() != [] ? $request->old() : null;
        $countries = Mine::join('countries', 'mines.country_id', '=', 'countries.id')
                            ->select('countries.country_name', 'countries.id as id','countries.amount_of_mines', DB::raw('COUNT(country_name) as count'))
                            ->groupBy('countries.country_name', 'countries.amount_of_mines', 'cosmos.countries.id')
                            ->havingRaw('COUNT(country_name) < amount_of_mines')
                            ->orderBy('country_name')
                            ->get();
        $ships = Ship::where('country_id', '=', null)->get();

        return view('mines.create', ['title '=> 'Create mine',
                                     'countries'=> $countries,
                                     'cntr'=> $cntr,
                                    'ships'=> $ships,
                                    'old'=> $old]);
    }

    public function store(Request $request)
    {
   
        // $maxMinesInCountry = Country::where('id', '=', $request['country'])->select('amount_of_mines')->first()->amount_of_mines;
        // $minesNowInCountry = Mine::where('country_id', '=', $request['country'])->count();

        $data = $request->all();
        $validator = Validator::make($data,
        [
            'mine-name'=> ['required', 'min:3', 'max:50', 'unique:mines,mine_name'],
            'country' => ['nullable', 'integer', Rule::in(Country::select('id')->get()->pluck('id')->all())],
            'longitude' => ['required', 
                            'integer', 
                            'min:0', 
                            'max:359',
                            Rule::unique('mines')->where(function ($query) use ($data) {
                                return $query->where('latitude', $data['latitude']);
                                }),
                            ],
            'latitude' => ['required', 'integer', 'min:0', 'max:359' ],
            'exploitation' => ['required', 'integer', 'min:1000', 'max:90000'],
            'add-ship' => ['array'],
            'add-ship.*' => ['numeric'],
        ],
        [
            'longitude.unique'=> 'This coordinations is already in use. Choose other coordinations.'
        ]);
        if($validator->fails()){
            $request->flash();
            return back()->withErrors($validator)->withInput();
        }
        $mine = new Mine;
        $mine->mine_name = $request['mine-name'];
        $mine->longitude = $request['longitude'];
        $mine->latitude = $request['latitude'];
        $mine->country_id = $request['country'];
        $mine->exploitation = $request['exploitation'];
        $mine->save();

        if($request['add-ship']){
            $mine->ships()->attach($request['add-ship']);
            Ship::whereIn('id', $request['add-ship'])->update(['country_id'=> $request['country']]);
        }

        return redirect()->route('mine-list')->with('message', $request['mine-name'].' mine is added.');
    }

    public function edit(Mine $mine)
    {
        $countries = Mine::join('countries', 'mines.country_id', '=', 'countries.id')
                            ->select('countries.country_name', 'countries.amount_of_mines', 'countries.id as id', DB::raw('COUNT(country_name) as count'))
                            ->groupBy('countries.country_name', 'countries.amount_of_mines', 'countries.id')
                            ->havingRaw('COUNT(country_name) < amount_of_mines')
                            ->orderBy('country_name')
                            ->get();
        $ships = Ship::where('country_id', '=', null)->get();

        return view('mines.edit', ['title '=> 'Edit mine',
                                      'countries'=> $countries,
                                      'mine'=> $mine,
                                      'ships'=> $ships]);
    }

    public function update(Request $request, Mine $mine)
    {
        $data = $request->all();

        $validator = Validator::make($data,
        [
            'mine-name'=> ['required', 'min:3', 'max:50', 'unique:mines,mine_name,'.$mine->id.'id'],
            'country' => ['nullable', 'integer', 'max:'.Country::count()],
            'longitude' => ['required', 
                            'integer', 
                            'min:0', 
                            'max:359',
                            Rule::unique('mines')->where(function ($query) use ($data) {
                                return $query->where('latitude', $data['latitude']);
                                })->ignore($mine->id),
                            ],
            'latitude' => ['required', 'integer', 'min:0', 'max:359' ],
            'exploitation' => ['required', 'integer', 'min:1000', 'max:90000'],
        ],
        [
            'longitude.unique'=> 'This coordinations is already in use. Choose other coordinations.'
        ]);
        if($validator->fails()){
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }

        $mine->mine_name = $request['mine-name'];
        $mine->longitude = $request['longitude'];
        $mine->latitude = $request['latitude'];
        $mine->country_id = $request['country'];
        $mine->exploitation = $request['exploitation'];
        $mine->save();

        $mine->ships()->detach();
        if($request['add-ship']){
            $mine->ships()->attach($request['add-ship']);
            Ship::whereIn('id', $request['add-ship'])->update(['country_id'=> $request['country']]);
        }



        return redirect()->route('mine-list')->with('message', $request['mine-name'].' mine is edited.');
    }

    public function destroy(Mine $mine)
    {
        if(Mine::where('id', $mine->id)->first() == null || !(int) $mine->id){
            return redirect()->route('mine-list')->with('message', 'Something went wrong. Mine is not identified.');
        }
        $mine->delete();
        return redirect()->back()->with('message', $mine->mine_name.' is deteted');
    }

    public function showLongitude(Request $request){
        $existingLongitudes = Mine::where('latitude', '=', $request->latitude)
                ->select('longitude')
               ->get()
               ->pluck('longitude')
               ->all();
                
        $availibleLongitudes =  array_values(array_diff(range(0,359), $existingLongitudes));

        return response()->json([
                            'longitudes' => $availibleLongitudes
        ]);
        
    }

    public function showLatitude(Request $request){
        $existingLatitudes = Mine::where('longitude', '=', $request->longitude)
                            ->select('latitude')
                            ->get()
                            ->pluck('latitude')
                            ->all();
                
        $availibleLatitudes =  array_values(array_diff(range(0,359), $existingLatitudes));

        return response()->json([
                            'latitudes' => $availibleLatitudes
        ]);
        
    }
    public function showCountryAndShips(Request $request){
        $countryName = Country::where('id', $request->countryId)
                    ->select('country_name')
                    ->first()
                    ->country_name;
        $ships = Ship::where('country_id', $request->countryId)
                    ->select('id', 'ship_name')
                    ->get();
        
                    
         if($request->mineId){
            $minesShips = Mine::where('id', $request->mineId)->first()->ships()->pluck('id')->all();
        }

        return response()->json([
                            'countryName' => $countryName,
                            'ships'=>$ships,
                            'minesShips'=> $minesShips ?? []
                             ]);            
    }
}
