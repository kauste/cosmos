@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row p-xl-2 p-md-1 p-0 justify-content-center">
        <div class="d-flex justify-content-center mt-3">
            <h2 class="border-bright p-3 pt-1">List of countries <i>involved</i></h2>
        </div>
        <div class="col-lg-7 col-12 m-2 d-flex justify-content-end">
            <a href="{{route('ship-create')}}" class="btn btn-outline-secondary btn-lg add-button">Add new ship</a>
        </div>
        <div class="col-xl-8 col-12 p-xl-5 pb-xl-0 pt-xl-2 p-0 bg-main scroll-table">
            @if(count($ships) !== 0)
            <table class="table table-hover">
                <thead class="border-bright-bottom">
                    <tr>
                        <th></th>
                        <th scope="col">Ship name</th>
                        <th scope="col">Country</th>
                        <th scope="col">List of mines</th>
                        <th scope="col">Aliance</th>
                        <th scope="col">Alliance mines</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ships as $ship)
                    <tr class="align-middle">
                        <th><img class="ship-img d-none d-md-flex" src="{{asset('/img/ship_img/'.$ship->ship_pic)}}" /></th>
                        <th scope="row">{{$ship->ship_name}}</th>
                        @if($ship->country)
                        <td>{{$ship->country->country_name}}</td>
                        @else
                        <td class="no-variables">No country</td>
                        @endif
                        <td>
                            @forelse ($ship->mines as $key => $mine)
                            <small>{{$mine->mine_name}}@if(count($ship->mines)-1 > $key), @else.@endif</small>
                            @empty
                            <small class="no-variables">No mine added yet.</small>
                            @endforelse
                        </td>
                        @if($ship->country?->alliance)
                        <td>{{$ship->country->alliance->alliance_name}}</td>
                        <td>
                            @foreach($ship->allianceCountries as $key => $allianceCountry)
                            @foreach($allianceCountry->allianceShips as $key2 => $allianceShip)
                            <small>{{$allianceShip->ship_name}}@if((count($ship->allianceCountries) * count($allianceCountry->allianceShips)) -1 > (($key + 1) * ($key2 + 1))), @else.@endif</small>
                            @endforeach
                            @endforeach
                        </td>
                        @else
                        <td>No alliance</td>
                        <td class="no-variables"><small>No alliance ships</small></td>
                        @endif
                        <td>
                            <a href="{{route('ship-edit', $ship)}}" class="btn btn-outline-secondary update-button mb-2">Edit</a>
                            <form method="post" action="{{route('ship-delete', $ship)}}">
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
