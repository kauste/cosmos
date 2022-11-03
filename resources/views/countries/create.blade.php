@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row p-2 justify-content-center">
        <div class="d-flex justify-content-center m-3">
            <h2 class="border-bright p-3 pt-1">Add new country</i></h2>
        </div>
        <div class="col-xxl-10 col-xl-12 p-5 pb-0 pl-3 pt-2 bg-main">
            <form class="m-2 row align-items-center">
                <div class="col-xl-5 col-lg-7  col-12 mb-3 d-flex gap-3 justify-content-start">
                    <label for="country-name" class="col-lg-3 col-5 mr-1 col-form-label">Country: </label>
                    <div class="col-lg-8 col-6">
                        <input  type="text" class="form-control country--name" id="country-name" list ="completed-countries" autocomplete="off">
                        <datalist id="completed-countries">
                        </datalist>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5 col-12 mb-3 d-flex gap-3  justify-content-start">
                    <label for="max-amount" class="col-lg-8 col-5 mr-1 col-form-label">Maximum amount of mines: </label>
                    <div class="col-lg-3 col-2">
                    <input type="number" class="form-control" id="max-amount">
                    </div>
                </div>
                <div class="col-xl-3 col-12 mt-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-outline-secondary update-button mb-3">Add country</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
