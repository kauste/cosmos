@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row p-2 justify-content-center">
        <div class="d-flex justify-content-center m-3">
            <h2 class="border-bright p-3 pt-1">Add new mine @if($cntr)for <b>{{$cntr->country_name}}</b>@endif</h2>
        </div>
        <div class="col-xl-5 col-lg-6 col-md-9 col-sm-11 col-12 p-sm-5 p-1 pb-0 pl-3 pt-2 bg-main">
            <form method="post" action="{{route('mine-store')}}" class="m-2 row align-items-center">
                @if($cntr)
                <div class="col-12 mb-4 d-flex gap-2 justify-content-start align-items-center">
                    <div class="col-4 mr-1 col-form-label">Country:</div>
                    <b class="col-7">{{$cntr->country_name}}</b>
                </div>
                @endif
                <div class="col-12 mb-4 d-flex gap-1 justify-content-start">
                    <label for="mine-name" class="col-4 mr-1 col-form-label">Mine name<span class="text-danger">&lowast;</span> :</label>
                    <div class="col-7">
                        <input type="text" class="form-control" id="mine-name" name="mine-name" @if($old) value="{{$old['mine-name']}}" @endif>
                    </div>
                </div>
                @if($cntr)
                <input name="country" id="country" value="{{$cntr->id}}" type="hidden" />
                @else
                <div class="col-12 mb-4 d-flex gap-1 justify-content-start">
                    <label for="country" class="col-4 mr-1 col-form-label">Country: </label>
                    <select class="col-7" name="country" id="country">
                        <option value="" @if($old && $old['country'] == "") selected @endif>No country</option>
                        @foreach ($countries as $country)
                        <option value="{{$country->id}}"  @if($old && $old['country'] == $country->id) selected @endif>{{$country->country_name}}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="col-12 mb-4 d-flex justify-content-start">
                    <div class="col-4 col-form-label">
                        <label class="col-10" for="longitude">Longitude<span class="text-danger">&lowast;</span> :</label>
                    </div>
                    <div class="col-4">
                        <input type="number" min="0" max="359" class="form-control" id="longitude" name="longitude" @if($old) value="{{$old['longitude']}}" @endif>
                    </div>
                    <div class=" col-5 d-flex justify-content-center">
                        <button class="btn btn-outline-secondary add-button longitude--button d-none " type="button">Show availible</button>
                        <button class="btn btn-outline-secondary add-button dont--longitude--button d-none " type="button">Don't show</button>
                    </div>
                </div>
                <div class="col-12 availible--longitude">
                </div>
                <div class="col-12 mb-4 d-flex  justify-content-start">
                    <div class="col-4 col-form-label">
                        <label class="col-10" for="latitude">Latitude<span class="text-danger">&lowast;</span> :</label>
                    </div>
                    <div class="col-4">
                        <input type="number" min="0" max="359" class="form-control" id="latitude" name="latitude" @if($old) value="{{$old['latitude']}}" @endif>
                    </div>
                    <div class="col-5 d-flex justify-content-center">
                        <button class="btn btn-outline-secondary add-button latitude--button d-none" type="button">Show availible</button>
                        <button class="btn btn-outline-secondary add-button dont--latitude--button d-none " type="button">Don't show</button>
                    </div>
                </div>
                <div class="col-12 availible--latitude">
                </div>
                <div class="col-12 mb-4 d-flex  justify-content-start">
                    <label for="exploitation" class="col-4 col-form-label">Exploitation<span class="text-danger">&lowast;</span> :</label>
                    <div class="col-4">
                        <input type="number" min="1000" max="90000" class="form-control" id="exploitation" name="exploitation" @if($old) value="{{$old['exploitation']}}" @endif>
                    </div>
                </div>
                <div class="col-12 mb-3 d-none gap-3  justify-content-start countries--ships">
                    <div for="add-mine" class="col-form-label col-4">
                    </div>
                    <ul>
                    </ul>
                </div>
                <div class="col-12 mb-3 d-flex gap-3  justify-content-start">
                    <div for="add-mine" class="col-form-label col-4">Add ship from stock
                        <br>
                        <small class="no-variables">Not necessary. You will be able to add your own ship.</small>
                    </div>
                    @if(count($ships) != 0)
                    <ul>
                        @foreach($ships as $ship)
                        <li style="list-style:none">
                            <input id="{{$ship->id}}" type="checkbox" name="add-ship[]" value="{{$ship->id}}">
                            <label for="{{$ship->id}}">{{$ship->ship_name}}</label>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <li style="list-style:none" class="col-form-label no-variables">There is no availible ship in stock. </li>
                    @endif
                </div>
                @csrf
                <div class="col-12 d-flex gap-3 justify-content-center">
                    <button type="submit" class="btn btn-outline-secondary update-button">Add mine</button>
                    <a href="{{route('mine-list')}}" class="btn btn-outline-secondary add-button">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
