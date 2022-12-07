@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row p-xl-2 p-1 justify-content-center">
        <div class="d-flex justify-content-center mt-3">
            <h2 class="border-bright p-3 pt-1">List of mines</h2>
        </div>
        <div class="col-lg-7 col-12 m-2 d-flex justify-content-end">
            <a href="{{route('mine-create')}}" class="btn btn-outline-secondary btn-lg add-button">Add new mine</a>
        </div>
        <div class="scroll-table col-xl-10 col-12 p-xl-5 pb-xl-0 pt-xl-2 p-0 bg-main">
            @if(count($mines) !== 0)
            <table class="table table-hover">
                <thead class="border-bright-bottom">
                    <tr>
                        <th scope="col">Mine name</th>
                        <th scope="col">Longitude</th>
                        <th scope="col">Latitude</th>
                        <th scope="col">Country</th>
                        <th scope="col">Exploitation</th>
                        <th scope="col">List of ships</th>
                        <th scope="col">Aliance</th>
                        <th scope="col">Alliance ships</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mines as $mine)
                    <tr>
                        <th scope="row">{{$mine->mine_name}}</th>
                        <td>{{$mine->longitude}}&deg</td>
                        <td>{{$mine->latitude}}&deg</td>
                        @if($mine->country)
                        <td>{{$mine->country->country_name}}</td>
                        @else
                        <td class="no-variables">No country</td>
                        @endif
                        <td>{{$mine->exploitation}} <i>kg/24h</i></td>
                        <td>
                            @forelse ( $mine->ships as $key=> $ship )
                            <small>{{$ship->ship_name}}@if(count($mine->ships)-1 > $key), @else.@endif</small>
                            @empty
                            <small class="no-variables">No ship added yet.</small>
                            @endforelse
                        </td>
                        @if($mine->country?->alliance)
                        <td>{{$mine->country->alliance->alliance_name}}</td>
                        <td>
                            @foreach($mine->allianceCountries as $key => $allianceCountry)
                            @foreach($allianceCountry->allianceShips as $key2 => $allianceShip)
                            <small>{{$allianceShip->ship_name}}@if((count($mine->allianceCountries) * count($allianceCountry->allianceShips)) -1 > (($key + 1) * ($key2 + 1))), @else.@endif</small>
                            @endforeach
                            @endforeach
                        </td>
                        @else
                        <td class="no-variables"><small>No alliance.</small></td>
                        <td><small class="no-variables">No alliance ships</small></td>
                        @endif
                        <td>
                            <a href="{{route('mine-edit', $mine)}}" class="btn btn-outline-secondary update-button mb-2">Edit</a>
                            <form method="post" action="{{route('mine-delete', $mine)}}">
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
