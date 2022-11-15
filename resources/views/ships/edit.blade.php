@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row p-2 justify-content-center">
        <div class="d-flex justify-content-center m-3">
            <h2 class="border-bright p-3 pt-1">Edit ship</h2>
        </div>
        <div class="col-xl-5 col-lg-6 col-md-9 col-sm-11 col-12 p-sm-5 p-1 pb-0 pl-3 pt-2 bg-main">
            <form method="post" enctype="multipart/form-data" action="{{route('ship-store')}}" class="m-2 row align-items-center">
                <div class="col-12 mb-4 d-flex gap-1 justify-content-start">
                    <label for="ship-name" class="col-4 mr-1 col-form-label">Ship name<span class="text-danger">&lowast;</span> :</label>
                    <div class="col-7">
                        <input type="text" class="form-control" id="ship-name" name="ship-name" value="{{$ship->ship_name}}" data-ship-id="{{$ship->id}}">
                    </div>
                </div>
                <div class="col-12 mb-4 d-flex gap-1 justify-content-start">
                    <label for="ship-pic col-4">Ship's picture:</label>
                    <input type="file" name="ship-pic" id="ship-pic" class="btn btn-outline-secondary add-button col-8">
                </div>
                <div class="col-12 mb-4 d-flex gap-1 justify-content-start">
                    <label for="country" class="col-4 mr-1 col-form-label">Country: </label>
                    <select class="col-7" name="country" id="country">
                        <option value=""  @if(null == $ship->country_id) selected @endif>No country</option>
                        @foreach ($countries as $country)
                        <option value="{{$country->id}}" @if($country->id == $ship->country_id) selected @endif>{{$country->country_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 mb-3 d-none gap-3  justify-content-start countries--mines">
                    <div for="add-mine" class="col-form-label col-4">
                    </div>
                    <ul>
                    </ul>
                </div>
                <div class="col-12 mb-3 d-flex gap-3  justify-content-start">
                    <div for="add-mine" class="col-form-label col-4">Add mine from stock
                        <br>
                        <small class="no-variables">Not necessary. You will be able to add your own mine.</small>
                    </div>
                    @if(count($mines) != 0)
                    <ul>
                        @foreach($mines as $mine)
                        <li style="list-style:none">
                            <input id="{{$mine->id}}" type="checkbox" name="add-mine[]" value="{{$mine->id}}">
                            <label for="{{$mine->id}}">{{$mine->mine_name}}</label>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <li style="list-style:none" class="col-form-label no-variables">There is no availible mine in stock. </li>
                    @endif
                </div>
                @csrf
                <div class="col-12 d-flex gap-3 justify-content-center">
                    <button type="submit" class="btn btn-outline-secondary update-button">Add ship</button>
                    <a href="{{route('ship-list')}}" class="btn btn-outline-secondary add-button">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection