@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row p-2 justify-content-center">
        <div class="d-flex justify-content-center m-3">
            <h2 class="border-bright p-3 pt-1">Edit mine <b>{{$mine->mine_name}}</b></h2>
        </div>
        <div class="col-xl-5 col-lg-6 col-md-9 col-sm-11 col-12 p-sm-5 p-1 pb-0 pl-3 pt-2 bg-main">
            <form method="post"action="{{route('mine-update', $mine)}}"class="m-2 row align-items-center">
                <div class="col-12 mb-4 d-flex gap-1 justify-content-start">
                    <label for="mine-name" class="col-3 mr-1 col-form-label">Mine name: </label>
                    <div class="col-7">
                        <input type="text" class="form-control" id="mine-name" name="mine-name" value="{{$mine->mine_name}}">
                    </div>
                </div>
                <div class="col-12 mb-4 d-flex gap-1 justify-content-start">
                    <label for="country" class="col-3 mr-1 col-form-label">Country: </label>
                    <select class="col-7" name="country" id="country">
                        @foreach ($countries as $country)
                        <option value="{{$country->id}}" @if($country->id == $mine->country_id) selected @endif>{{$country->country_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 mb-4 d-flex justify-content-start">
                    <label for="longitude" class="col-6 col-form-label">Longitude: </label>
                    <div class="col-5">
                        <input type="number" min="0" max="359" class="form-control" id="longitude" name="longitude" value="{{$mine->longitude}}">
                    </div>
                </div>
                <div class="col-6 mb-4 d-flex  justify-content-start">
                    <label for="latitude" class="col-6 col-form-label">Latitude: </label>
                    <div class="col-5">
                        <input type="number" min="0" max="359" class="form-control" id="latitude" name="latitude" value="{{$mine->latitude}}">
                    </div>
                </div>
                <div class="col-12 mb-4 d-flex  justify-content-start">
                    <label for="exploitation" class="col-3 col-form-label">Digging capacity: </label>
                    <div class="col-3">
                        <input type="number" min="1000" max="90000" class="form-control" id="exploitation" name="exploitation" value="{{$mine->exploitation}}">
                    </div>
                </div>
                @method('put')
                @csrf
                <div class="col-12 d-flex justify-content-center">
                    <button type="submit" class="btn btn-outline-secondary update-button">Edit mine</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection