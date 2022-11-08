<?php

namespace App\Http\Controllers;

use App\Models\Mine;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use DB;

class MineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $mines = Mine::orderBy('mine_name')->get();

        return view('mines.list', ['title' => 'List of mines',
                                   'mines' => $mines]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($country = null)
    {
        $cntr = Country::where('id',$country)->first();
        $countries = Mine::join('countries', 'mines.country_id', '=', 'countries.id')
                            ->select('countries.country_name', 'countries.id as id','countries.amount_of_mines', DB::raw('COUNT(country_name) as count'))
                            ->groupBy('countries.country_name', 'countries.amount_of_mines', 'cosmos.countries.id')
                            ->havingRaw('COUNT(country_name) < amount_of_mines')
                            ->orderBy('country_name')
                            ->get();

        return view('mines.create', ['title '=> 'Create mine',
                                     'countries'=> $countries,
                                     'cntr'=> $cntr]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMineRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
   
        // $maxMinesInCountry = Country::where('id', '=', $request['country'])->select('amount_of_mines')->first()->amount_of_mines;
        // $minesNowInCountry = Mine::where('country_id', '=', $request['country'])->count();

        $data = $request->all();
        dump($data);

        $validator = Validator::make($data,
        [
            'mine-name'=> ['required', 'min:3', 'max:50', 'unique:mines,mine_name'],
            'country' => ['required', 'integer', 'max:'.Country::count()],
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
        ],
        [
            'longitude.unique'=> 'This coordinations is already in use. Choose other coordinations.'
        ]);
        if($validator->fails()){
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }
        $mine = new Mine;
        $mine->mine_name = $request['mine-name'];
        $mine->longitude = $request['longitude'];
        $mine->latitude = $request['latitude'];
        $mine->country_id = $request['country'];
        $mine->exploitation = $request['exploitation'];
        $mine->save();
        return redirect()->route('mine-list')->with('message', $request['mine-name'].' mine is added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mine  $mine
     * @return \Illuminate\Http\Response
     */
    public function show(Mine $mine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mine  $mine
     * @return \Illuminate\Http\Response
     */
    public function edit(Mine $mine)
    {
        $countries = Mine::join('countries', 'mines.country_id', '=', 'countries.id')
                            ->select('countries.country_name', 'countries.amount_of_mines', 'countries.id as id', DB::raw('COUNT(country_name) as count'))
                            ->groupBy('countries.country_name', 'countries.amount_of_mines', 'countries.id')
                            ->havingRaw('COUNT(country_name) < amount_of_mines')
                            ->orderBy('country_name')
                            ->get();

        return view('mines.edit', ['title '=> 'Edit mine',
                                      'countries'=> $countries,
                                      'mine'=> $mine]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMineRequest  $request
     * @param  \App\Models\Mine  $mine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mine $mine)
    {
        $data = $request->all();

        $validator = Validator::make($data,
        [
            'mine-name'=> ['required', 'min:3', 'max:50', 'unique:mines,mine_name,'.$mine->id.'id'],
            'country' => ['required', 'integer', 'max:'.Country::count()],
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
        return redirect()->route('mine-list')->with('message', $request['mine-name'].' mine is edited.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mine  $mine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mine $mine)
    {
        $mine->delete();
        return redirect()->back()->with('message', $mine->mine_name.' is deteted');
    }

    public function showLongitude(Request $request){
        $existingLongitudes = Mine::where('latitude', '=', $request->latitude)
                ->select('longitude')
               ->get()
               ->pluck('longitude')
               ->all();
                
        $availibleLongitudes =  array_diff(range(0,359), $existingLongitudes);
        
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
                
        $availibleLatitudes =  array_diff(range(0,359), $existingLatitudes);
        
        return response()->json([
                            'latitudes' => $availibleLatitudes
        ]);
        
    }
}
