@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row p-xl-2 p-1 justify-content-center">
        <div class="d-flex justify-content-center mt-3">
            <h2 class="border-bright p-3 pt-1">List of countries <i>involved</i></h2>
        </div>
        <div class="col-lg-7 col-12 m-2 d-flex justify-content-end">
        <a href="{{route('mine-create')}}" class="btn btn-outline-secondary btn-lg add-button">Add new mine</a>
        </div>
        <div class="col-xl-8 col-12 p-xl-5 pb-xl-0 pt-xl-2 p-0 bg-main">
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
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($mines as $mine)
                <tr>
                    <th scope="row">{{$mine->mine_name}}</th>
                    <td>{{$mine->longitude}}&deg</td>
                    <td>{{$mine->latitude}}&deg</td>
                    <td>{{$mine->country->country_name}}</td>
                    <td>{{$mine->exploitation}} <i>kh/24h</i></td>
                    <td>To be continued</td>
                    <td>
                        <a href="{{route('mine-edit', $mine)}}" class="btn btn-outline-secondary update-button">Edit</a>
                    </td>
                    <td>
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
            <i> No countries are involved in the project. </i>
            @endif
        </div>
    </div>
</div>
@endsection
