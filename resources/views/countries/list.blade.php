@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row p-1 justify-content-center">
        <div class="d-flex justify-content-center mt-3">
            <h2 class="border-bright p-3 pt-1">List of countries <i>involved</i></h2>
        </div>
        <div class="col-lg-7 col-12 m-2 d-flex justify-content-end">
            <a href="{{route('country-create')}}" class="btn btn-outline-secondary btn-lg create-button">Add new country</a>
        </div>
        <div class="scroll-table col-12 p-md-5 pb-md-0 pt-md-2 p-0 bg-main">
            @if(count($countries) !== 0)
            <table class="table table-hover">
                <thead class="border-bright-bottom">
                    <tr>
                        <th scope="col">Country</th>
                        <th scope="col">Mines (max mines)</th>
                        <th scope="col">List of mines</th>
                        <th scope="col">List of ships</th>
                        <th scope="col">Aliance</th>
                        <th scope="col">Alliance ships</th>
                        <th scope="col">Alliance mines</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($countries as $country)
                    <tr class="align-middle">
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
                        @if($country->alliance)
                        <td>{{$country->alliance->alliance_name}}</td>
                        <td>
                            @foreach($country->allianceCountries as $key => $allianceCountry)
                            @forelse($allianceCountry->allianceShips as $key2 => $allianceShip)
                            <small>{{$allianceShip->ship_name}}@if((count($country->allianceCountries) * count($allianceCountry->allianceShips)) -1 > (($key + 1) * ($key2 + 1))), @else.@endif</small>
                            @empty
                            <small class="no-variables">No alliance ships.</small>
                            @endforelse
                            @endforeach
                        </td>
                        <td>
                            @foreach($country->allianceCountries as $key => $allianceCountry)
                            @forelse($allianceCountry->allianceMines as $key2 => $allianceMine)
                            <small>{{$allianceMine->mine_name}}@if((count($country->allianceCountries) * count($allianceCountry->allianceMines)) -1 > (($key + 1) * ($key2 + 1))), @else.@endif</small>
                            @empty
                            <small class="no-variables">No alliance mines.</small>
                            @endforelse
                            @endforeach
                        </td>
                        @else
                        <td class="no-variables"><small>No alliance.</small></td>
                        <td><small class="no-variables">No alliance ships.</small></td>
                        <td><small class="no-variables">No alliance mines.</small></td>
                        @endif
                        <td>
                            <a href="{{route('country-edit', $country)}}" class="btn btn-outline-secondary update-button mb-2">Edit</a>
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
            <div class="p-3"><i> No countries are involved in the project. </i></div>
            @endif
        </div>
    </div>
</div>
@endsection
