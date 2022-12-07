@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row p-2 justify-content-center">
        <div class="d-flex justify-content-center m-3">
            <h2 class="border-bright p-3 pt-1">Edit alliance <b>{{$alliance->alliance_name}}</b></h2>
        </div>
        <div class="col-xxl-5 col-lg-7 col-md-9 p-md-5 p-2 pb-0 pl-3 pt-2 bg-main">
            <form method="post" action="{{route('alliance-update', $alliance)}}" class="m-2 row align-items-center">
                <div class="col-12 mb-3 d-flex gap-3 justify-content-center">
                    <label for="country-name" class="col-form-label">Alliance name <span class="text-danger">&lowast;</span> :</label>
                    <div>
                        <input type="text" class="form-control" id="alliance-name" name="alliance-name" list="completed-countries" autocomplete="off" value="{{$alliance->alliance_name}}">
                    </div>
                </div>
                @method('put')
                @csrf
                <div class="col-12 mt-3 d-flex  gap-3 justify-content-center">
                    <button type="submit" class="btn btn-outline-secondary update-button mb-3">Update</button>
                    <a href="{{route('alliance-list')}}" class="btn btn-outline-secondary add-button mb-3">Cancel</a>
                </div>
            </form>
            <div class="text-danger">&lowast; - essential fields</div>
        </div>
    </div>
</div>
@endsection
