<?php

namespace App\Http\Controllers;

use App\Models\Ship;
use App\Models\Mine;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use DB;

class ShipController extends Controller
{

    public function index()
    {
        $ships = Ship::orderBy('ship_name')->get();

        return view('ships.list', ['title' => 'List of ships',
                                   'ships' => $ships]);
    }

    public function create($country = null)
    {
        $cntr = Country::where('id',$country)->first();
        $countries = Country::select('countries.country_name', 'countries.id as id')
                            ->orderBy('country_name')
                            ->get();

        $mines = Mine::where('country_id', '=', null)->get();

        return view('ships.create', ['title '=> 'Create mine',
                                     'countries'=> $countries,
                                     'cntr'=> $cntr,
                                    'mines'=> $mines]);
    }
    
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),
        [
            'ship-name'=> ['required', 'min:3', 'max:50', 'unique:ships,ship_name'],
            'country' => ['nullable', 'integer', Rule::in(Country::select('id')->get()->pluck('id')->all())],
            'ship_pic' => ['mimes:jpg,gif,svg,jpeg,png', 'max:2048'],
            'add-mine' => ['array'],
            'add-mine.*' => ['numeric'],
        ]);
        if($validator->fails()){
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }
        $ship = new Ship;
        $ship->ship_name = $request['ship-name'];
        $ship->country_id = $request['country'];
        
        if($request->file('ship-pic')){
            $originalPic = $request->file('ship-pic');

            $extention = $originalPic->getClientOriginalExtension();
            $name = pathinfo($originalPic->getClientOriginalName(), PATHINFO_FILENAME);
            $file = $name. '-' . rand(100000, 999999). '.' . $extention;
            dump(public_path().'/img/ship_img/'.$file);
            $originalPic->move(public_path().'/img/ship_img', $file);
            $ship->ship_pic = $file;
        }
        $ship->save();

        if($request['add-mine']){
            $ship->mines()->attach($request['add-mine']);
            Mine::whereIn('id', $request['add-mine'])->update(['country_id'=> $request['country']]);
        }

        return redirect()->route('ship-list')->with('message', $request['ship-name'].' ship is added.');
    }

    public function edit(Ship $ship)
    {
        $countries = Country::select('countries.country_name', 'countries.id as id')
                            ->orderBy('country_name')
                            ->get();

        $mines = Mine::where('country_id', '=', null)->get();

        return view('ships.edit', ['title '=> 'Create mine',
                                    'countries'=> $countries,
                                    'mines'=> $mines,
                                    'ship' => $ship]);
    }

    public function update(UpdateShipRequest $request, Ship $ship)
    {
        $validator = Validator::make($request->all(),
        [
            'ship-name'=> ['required', 'min:3', 'max:50', 'unique:ships,ship_name'],
            'country' => ['nullable', 'integer', Rule::in(Country::select('id')->get()->pluck('id')->all())],
            'ship_pic' => ['mimes:jpg,gif,svg,jpeg,png', 'max:2048'],
            'add-mine' => ['array'],
            'add-mine.*' => ['numeric'],
        ]);
        if($validator->fails()){
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }

        $ship->ship_name = $request['ship-name'];
        $ship->country_id = $request['country'];
        
        if($request->file('ship-pic')){
            if($ship->ship_pic){
                $pic_asset = $ship->ship_pic;
                $name = pathinfo($pic_asset, PATHINFO_FILENAME);
                $ext = pathinfo($pic_asset, PATHINFO_EXTENSION);
                $pic_path = public_path() . '/images/'. $name . '.' .$ext;
                if (file_exists($pic_path)) {
                    unlink($pic_path);
                }
            }
            $originalPic = $request->file('ship-pic');

            $extention = $originalPic->getClientOriginalExtension();
            $name = pathinfo($originalPic->getClientOriginalName(), PATHINFO_FILENAME);
            $file = $name. '-' . rand(100000, 999999). '.' . $extention;

            $originalPic->move(public_path().'/img/ship_img', $file);
            $ship->ship_pic = $file;
        }
        $ship->save();

        $ship->mines()->detach();
        if($request['add-mine']){
            $ship->mines()->attach($request['add-mine']);
            Mine::whereIn('id', $request['add-mine'])->update(['country_id'=> $request['country']]);
        }

        return redirect()->route('ship-list')->with('message', $request['ship-name'].' ship is edited.');
    }

    public function destroy(Ship $ship)
    {
        if(Ship::where('id', $ship->id)->first() == null || !(int) $ship->id){
            return redirect()->route('ship-list')->with('message', 'Something went wrong. Ship is not identified.');
        }

        if($ship->ship_pic){
            $pic_asset = $ship->ship_pic;
            $name = pathinfo($pic_asset, PATHINFO_FILENAME);
            $ext = pathinfo($pic_asset, PATHINFO_EXTENSION);
            $pic_path = public_path() . '/images/'. $name . '.' .$ext;
            if (file_exists($pic_path)) {
                unlink($pic_path);
            }
        }
        $ship->delete();

        return redirect()->route('ship-list')->with('message', $ship->ship_name.' ship is deleted.');
    }
    public function showCountryAndMines(Request $request){
        $countryName = Country::where('id', $request->countryId)
        ->select('country_name')
        ->first()
        ->country_name;

        $mines = Mine::where('country_id', $request->countryId)
        ->select('id', 'mine_name')
        ->get();

        
        if($request->shipId){
        $shipsMines = Ship::where('id', $request->shipId)->first()->mines()->pluck('id')->all();
        }

         return response()->json([
                'countryName' => $countryName,
                'mines'=>$mines,
                'shipsMines'=> $shipsMines ?? []
                 ]);         
    }
}
