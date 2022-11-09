@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row p-2 justify-content-center">
        <div class="d-flex justify-content-center mt-3">
            <h2 class="border-bright p-3 pt-1">List of countries <i>involved</i></h2>
        </div>
        <div class="col-lg-7 col-12 m-2 d-flex justify-content-end">
        <a href="{{route('country-create')}}" class="btn btn-outline-secondary btn-lg create-button">Add new country</a>
        </div>
        <div class="col-lg-8 col-12 p-sm-5 pb-sm-0 pt-sm-2 p-0 bg-main">
            @if(count($countries) !== 0)
            <table class="table table-hover">
                <thead class="border-bright-bottom">
                    <tr>
                        <th scope="col teal">Country name</th>
                        <th scope="col">Mines (max mines)</th>
                        <th scope="col">List of mines</th>
                        <th scope="col">List of ships</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($countries as $country)
                <tr>
                    <th scope="row">{{$country->country_name}}</th>
                    <td>{{$country->mines()->count()}} ({{$country->amount_of_mines}})</td>
                    <td>
                        @forelse ( $country->mines as $key=> $mine )
                            <small>{{$mine->mine_name}}@if(count($country->mines)-1 > $key), @else.@endif</small>
                        @empty
                            <small class="no-variables">No mine added yet.</small>
                        @endforelse
                    </td>
                       <td>
                        
                        @forelse ( $country->ships as $key=> $ship )
                            <small>{{$ship->ship_name}}@if(count($country->ships)-1 > $key), @else.@endif</small>
                        @empty
                            <small class="no-variables">No ship added yet.</small>
                        @endforelse
                    </td>
                    <td>
                        <a href="{{route('country-edit', $country)}}" class="btn btn-outline-secondary update-button">Edit</a>
                    </td>
                    <td>
                        <form method="post" action="{{route('country-delete', $country)}}">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-secondary delete-button">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            @else
            <i> No countries are involved in the project. </i>
            @endif
        </div>
    </div>
</div>
@endsection
