@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row p-1 justify-content-center">
        <div class="d-flex justify-content-center mt-3">
            <h2 class="border-bright p-3 pt-1">List of alliances</h2>
        </div>
        <div class="col-lg-7 col-12 m-2 d-flex justify-content-end">
            <a href="{{route('alliance-create')}}" class="btn btn-outline-secondary btn-lg create-button">Add new alliance</a>
        </div>
        <div class="scroll-table col-12 p-md-5 pb-md-0 pt-md-2 p-0 bg-main">
            @if(count($alliances) !== 0)
            <table class="table table-hover">
                <thead class="border-bright-bottom">
                    <tr>
                        <th scope="col">Alliance</th>
                        <th scope="col">Alliance countries</th>
                        <th scope="col">Alliance ships</th>
                        <th scope="col">Alliance mines</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alliances as $alliance)
                    <tr class="align-middle">
                        <th scope="row">{{$alliance->alliance_name}}</th>
                        <td>
                            @forelse ($alliance->alliance_countries as $key=> $alliance_country )
                            <small>{{$alliance_country->country_name}}@if(count($alliance->alliance_countries)-1 > $key), @else.@endif</small>
                            @empty
                            <small class="no-variables">No country added yet.</small>
                            @endforelse
                        </td>
                        <td>
                            @forelse ($alliance->alliance_countries as $key=> $alliance_country )
                            @forelse ( $alliance_country->country_mines as $key=> $country_mine )
                            <small>{{$country_mine->mine_name}}@if(count($alliance_country->country_mines)-1 > $key), @else.@endif</small>
                            @empty
                            <small class="no-variables">Countries have no mine.</small>
                            @endforelse
                            @empty
                            <small class="no-variables">Countries have no mine.</small>
                            @endforelse
                        </td>
                        <td>
                            @forelse($alliance->alliance_countries as $key=> $alliance_country )
                            @forelse ( $alliance_country->country_ships as $key=> $country_ship )
                            <small>{{$country_ship->ship_name}}@if(count($alliance_country->country_ships)-1 > $key), @else.@endif</small>
                            @empty
                            <small class="no-variables">Countries have no ship.</small>
                            @endforelse
                            @empty
                            <small class="no-variables">Countries have no ship.</small>
                            @endforelse
                        </td>
                        <td>
                            <a href="{{route('alliance-edit', $alliance)}}" class="btn btn-outline-secondary update-button mb-2">Edit</a>
                            <form method="post" action="{{route('alliance-delete', $alliance)}}">
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
            <i> No alliances are involved in the project. </i>
            @endif
        </div>
    </div>
</div>
@endsection
