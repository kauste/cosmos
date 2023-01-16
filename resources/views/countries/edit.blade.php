@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row p-2 justify-content-center">
        <div class="d-flex justify-content-center m-3">
            <h2 class="border-bright p-3 pt-1">Edit country <b>{{$country->country_name}}</b></h2>
        </div>
        <div class="col-12 d-flex justify-content-center gap-2 gap-sm-5 mb-2">
            @if(!$isMaxMines)
            <a href="{{route('mine-create-for-country', $country)}}" class="btn btn-outline-secondary add-button">Create new mine</a>
            @endif
             <a href="{{route('ship-create-for-country', $country)}}" class="btn btn-outline-secondary add-button">Create new ship</a>
        </div>
        <div class="col-xxl-5 col-xl-7 p-0 p-sm-5 pb-sm-0 pl-sm-3 pt-sm-2 bg-main">
            <form method="post" action="{{route('country-update', $country)}}" class="m-2 row align-items-center">
                <div class="col-12 mb-3 d-flex flex-column flex-sm-row gap-1 gap-sm-3 justify-content-start">
                    <label for="country-name" class="col-form-label">Country: </label>
                    <div>
                        <input type="text" class="form-control country--name" id="country-name" name="country-name" value="{{$country->country_name}}" disabled>
                    </div>
                </div>
                <div class="col-12 mb-3 d-flex flex-column flex-sm-row gap-1 gap-sm-3 justify-content-start">
                    <label for="max-amount" class="col-form-label">Maximum amount of mines<span class="text-danger">&lowast;</span> :</label>
                    <div>
                        <input type="number" min="3" max="50" class="form-control two-digit-number-input" id="max-amount" name="max-amount" value="{{$country->amount_of_mines}}">
                    </div>
                </div>
                                @if($alliances)
                <div class="mb-3 d-flex flex-column flex-sm-row gap-1 gap-sm-3 justify-content-start">
                    <div class="col-12 col-sm-3">
                    <label for="alliance" class="mr-1 col-form-label">Alliance: </label>
                    </div>
                    <select class="form-control alliance-select h-50" name="alliance" id="alliance">
                        <option value="" @if($country->alliance_id == null) selected @endif>No alliance</option>
                        @foreach ($alliances as $alliance)
                        <option value="{{$alliance->id}}" @if($country->alliance_id == $alliance->id) selected @endif>{{$alliance->alliance_name}}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="col-12 mb-3 d-flex flex-column flex-sm-row gap-1 gap-sm-3  justify-content-start">
                    <div for="add-mine" class="col-form-label col-12 col-sm-3">Add or remove mines
                        <i>(longitude x latitude)</i>:
                        <br>
                        <small class="no-variables">Availible mines. Checked is already belongs to {{$country->country_name}}</small>
                    </div>
                    @if(count($availibleMines) != 0 || count($country->mines) != 0)
                    <ul>
                        @if(count($country->mines) != 0)
                        @foreach($country->mines as $mine)
                        <li style="list-style:none">
                            <input id="{{$mine->id}}" type="checkbox" name="add-mine[]" value="{{$mine->id}}" checked>
                            <label for="{{$mine->id}}">{{$mine->mine_name}} <i>({{$mine->longitude}}&deg x {{$mine->latitude}}&deg)</i></label>
                        </li>
                        @endforeach
                        @endif
                        @if(count($availibleMines) != 0)
                        @foreach($availibleMines as $mine)
                        <li style="list-style:none">
                            <input id="{{$mine->id}}" type="checkbox" name="add-mine[]" value="{{$mine->id}}">
                            <label for="{{$mine->id}}">{{$mine->mine_name}} <i>({{$mine->longitude}}&deg x {{$mine->latitude}}&deg)</i></label>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                    @else
                    <div for="add-mine" class="col-form-label no-variables">There is no availible mines to add. You will have to dig a new one. </div>
                    @endif
                </div>

                <div class="col-12 mb-3 d-flex flex-column flex-sm-row gap-1 gap-sm-3  justify-content-start">
                    <div for="add-mine" class="col-form-label col-12 col-sm-3">Add or remove ships
                        <br>
                        <small class="no-variables">Availible ships. Checked is already belongs to {{$country->country_name}}</small>
                    </div>
                    @if(count($ships) != 0 || count($country->ships) != 0)
                    <ul>
                        @if(count($country->ships) != 0)
                        @foreach($country->ships as $ship)
                        <li style="list-style:none">
                            <input id="{{$ship->id}}" type="checkbox" name="add-ship[]" value="{{$ship->id}}" checked>
                            <label for="{{$ship->id}}">{{$ship->ship_name}}</label>
                        </li>
                        @endforeach
                        @endif
                        @if(count($ships) != 0)
                        @foreach($ships as $ship)
                        <li style="list-style:none">
                            <input id="{{$ship->id}}" type="checkbox" name="add-ship[]" value="{{$ship->id}}">
                            <label for="{{$ship->id}}">{{$ship->ship_name}}</label>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <div for="add-mine" class="col-form-label no-variables">There is no availible ship to add. You will have to get your own. </div>
                    @endif
                    </ul>
                    @else
                    <div for="add-mine" class="col-form-label no-variables">There is no availible mines to add. You will have to dig a new one. </div>
                    @endif
                </div>
                @csrf
                @method('put')
                <div class="col-12 mt-3 d-flex gap-3 justify-content-center">
                    <button type="submit" class="btn btn-outline-secondary update-button mb-3">Update</button>
                    <a href="{{route('country-list')}}" class="btn btn-outline-secondary add-button mb-3">Cancel</a>
                </div>
            </form>
            <div class="text-danger">&lowast; - essential fields</div>
        </div>
    </div>
</div>
@endsection
