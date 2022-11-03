@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row p-2 justify-content-center">
        <div class="d-flex justify-content-center mt-3">
            <h2 class="border-bright p-3 pt-1">List of countries <i>involved</i></h2>
        </div>
        <div class="col-7 m-2 d-flex justify-content-end">
        <a href="{{route('country-create')}}" class="btn btn-outline-secondary btn-lg add-button">Add new country</a>
        </div>
        <div class="col-8 p-5 pb-0 pt-2 bg-main">
            @if(count($countries) !== 0)
            <table class="table table-hover">
                <thead class="border-bright-bottom">
                    <tr>
                        <th scope="col teal">Country name</th>
                        <th scope="col">Mines (max mines)</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($countries as $country)
                <tr>
                    <th scope="row">{{$country->country_name}}</th>
                    <td>0 ({{$country->amount_of_mines}})</td>
                    <td>
                        <a href="#" class="btn btn-outline-secondary update-button">Update</a>
                    </td>
                    <td>
                        <form method="post" action="">
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
