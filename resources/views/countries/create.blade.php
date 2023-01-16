@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row p-2 justify-content-center">
        <div class="d-flex justify-content-center m-3">
            <h2 class="border-bright p-3 pt-1">Add new country</i></h2>
        </div>
        <div class="col-xxl-5 col-lg-7 col-md-9 p-md-5 p-2 pb-0 pl-3 pt-2 bg-main">
            <form method="post" action="{{route('country-store')}}" class="m-2 row align-items-center">
                <div class="col-12 mb-3 d-flex flex-column flex-sm-row gap-1 gap-sm-3 justify-content-start">
                    <label for="country-name" class="col-form-label">Country <span class="text-danger">&lowast;</span> :</label>
                    <div class="country-name-input">
                        <input type="text" class="form-control country--name" id="country-name" name="country-name" list="completed-countries" autocomplete="off" @if($old) value="{{$old['country-name']}}" @endif>
                        <datalist id="completed-countries">
                        </datalist>
                    </div>
                </div>
                <div class="col-12 mb-3 d-flex flex-column flex-sm-row gap-1 gap-sm-3  justify-content-start">
                    <label for="max-amount" class="col-form-label">Maximum amount of mines <span class="text-danger">&lowast;</span> :</label>
                    <div class="">
                        <input type="number" min="3" max="50" class="form-control two-digit-number-input" id="max-amount" name="max-amount" @if($old) value="{{$old['max-amount']}}" @endif>
                    </div>
                </div>
                @if($alliances)
                <div class="mb-3 d-flex flex-column flex-sm-row gap-1 gap-sm-3 justify-content-start">
                    <div class="col-sm-3">
                    <label for="alliance" class="mr-1 col-form-label">Alliance: </label>
                    </div>
                    <select class="form-control alliance-select h-50" name="alliance" id="alliance">
                        <option value="" @if($old && $old['alliance']=="" ) selected @endif>No alliance</option>
                        @foreach ($alliances as $alliance)
                        <option value="{{$alliance->id}}" @if($old && $old['alliance']==$alliance->id) selected @endif>{{$alliance->alliance_name}}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="col-12 mb-3 d-flex flex-column flex-sm-row gap-1 gap-sm-3  justify-content-start">
                    <div for="add-mine" class="col-form-label col-12 col-sm-3">Add mine from stock
                        <i>(longitude x latitude)</i>:
                        <br>
                        <small class="no-variables">Not necessary. You will be able to dig a new one.</small>
                    </div>
                    @if(count($mines) != 0)
                    <ul>
                        @foreach($mines as $mine)
                        <li style="list-style:none">
                            <input id="{{$mine->id}}" type="checkbox" name="add-mine[]" value="{{$mine->id}}">
                            <label for="{{$mine->id}}">{{$mine->mine_name}} <i>({{$mine->longitude}}&deg x {{$mine->latitude}}&deg)</i></label>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <div for="add-mine" class="col-form-label no-variables">There is no availible mines to add. You will have to dig a new one. </div>
                    @endif
                </div>
                <div class="col-12 mb-3 d-flex flex-column flex-sm-row gap-1 gap-sm-3  justify-content-start">
                    <div for="add-mine" class="col-form-label col-12 col-sm-3">Add ship from stock
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
                    <div for="add-mine" class="col-form-label no-variables">There is no availible ship to add. You will have to get your own. </div>
                    @endif
                </div>
                @csrf
                <div class="col-12 mt-3 d-flex  gap-3 justify-content-center">
                    <button type="submit" class="btn btn-outline-secondary update-button mb-3">Add country</button>
                    <a href="{{route('country-list')}}" class="btn btn-outline-secondary add-button mb-3">Cancel</a>
                </div>
            </form>
            <div class="text-danger">&lowast; - essential fields</div>
        </div>
    </div>
</div>
@endsection
