<?php

namespace App\Http\Controllers;

use App\Models\Alliance;
use App\Models\Country;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AllianceController extends Controller
{

    public function index()
    {
        $alliances = Alliance::orderBy(
                	Country::select(DB::raw('count(alliance_id)'))
                    ->whereColumn('countries.alliance_id', 'alliances.id'), 'desc')->get()      
                        ->map(function($alliance){
                            $alliance->alliance_countries = $alliance->countries
                            ->map(function($country){
                                $country->country_ships = $country->ships;
                                $country->country_mines = $country->mines;
                                return $country;
                            });
                            return $alliance;
                        });
                    // dd($alliances);
        return view('alliances.list', [ 'title' => 'Alliances list',
                                        'alliances'=> $alliances]);
    }

    public function create(Request $request)
    {
        $old = $request->old() != [] ? $request->old() : null;
        return view('alliances.create', [ 'title' => 'Create alliance',
                                        'old' => $old]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'alliance-name' => ['required', 'string', 'min:3', 'max:100', 'unique:alliances,alliance_name']
        ]);
        if($validator->fails()){
            $request->flash();
            return redirect()->back()->withErrors($validator);

        }
        $alliance = new Alliance;
        $alliance->alliance_name = $request['alliance-name'];
        $alliance->save();
        return redirect()->route('alliance-list')->with('message', 'Alliance is added successfully. You can add countries to alliance now.');
    }


    public function show(Alliance $alliance)
    {
        //
    }

    public function edit(Alliance $alliance)
    {
        return view('alliances.edit', [ 'title' => 'Edit alliance',
                                        'alliance' => $alliance]);
    }

    public function update(Request $request, Alliance $alliance)
    {
        $validator = Validator::make($request->all(), [
            'alliance-name' => ['required', 'string', 'min:3', 'max:100', 'unique:alliances,alliance_name']
        ]);

        if($validator->fails()){
            $request->flash();
            return redirect()->back()->withErrors($validator);

        }

        $alliance->alliance_name = $request['alliance-name'];
        $alliance->save();
        return redirect()->route('alliance-list')->with('message', 'Alliance is added successfully. You can add countries to alliance now.');
    }

    public function destroy(Alliance $alliance)
    {
        Country::where('alliance_id', $alliance->id)->update(['alliance_id'=> null]);
        $alliance->delete();
        return redirect()->back()->with('message', 'Alliance is deleted.');
    }
}
