@extends('layouts.app')

@section('content')
<div class="container p-0 p-sm-2">
    <div class="row p-0 p-xl-3">
    <div class="align-items-center d-flex flex-column-reverse flex-md-row justify-content-end">
        @if(!auth()->user()?->id)
        <form method="post" action="{{route('emile')}}" class="m-2 ">
            <div class=" m-4 d-flex gap-1 justify-content-end align-items-center">
                <label for="email" class="">Ask for login data: </label>
                <input type="email" class="form-control h-25 p-2 " id="email" name="email" placeholder="email" required>
                @csrf
                <button type="submit" class="btn btn-outline-secondary add-button h-25">Send</button>
            </div>
        </form>
         <a class="m-2 text-black" href="https://github.com/kauste/cosmos" target="_blank">See the code</a>
        @endif
       </div>
    </div>

    <div class="row p-1 justify-content-center">
        <div class="p-4 pb-3 text-center">
            <h4 class="p-0">As the global energy crisis deepened, it was decided to start mining helium 3 on the moon:</h4>
        </div>
        <div class="d-flex justify-content-center m-3">
            <h2 class="border-bright p-3 pt-1">Vision:</h2>
        </div>
        <ul class="first-list d-flex justify-content-center gap-5 flex-wrap">
            <div class="bg-main p-4 col-12 col-md-5 rounded shadow">
                <li><b>Creation, editing and deletion of new <u>countries</u> participating in moon mining. Each country must have the following attributes:</b></li>
                <ul class="second-list">
                    <li>Title </li>
                    <li>Planned number of mines (must not allow country to have more mines than stated)</li>
                </ul>
            </div>
            <div class="bg-main p-4 col-12 col-md-5 rounded shadow">
                <li><b>Creation, editing, destruction of new <u>mines</u> on the lunar surface. Each mine must have the following attributes:</b></li>
                <ul class="second-list">
                    <li>Coordinates - degrees of longitude and latitude according to the lunar coordinate system</li>
                    <li>Title</li>
                    <li>Country that owns the mine from the list</li>
                    <li>Helium 3 degradation capacity in kg per earth day</li>
                    <li>List of ships transporting Helium 3 out of the mine</li>
                </ul>
            </div>
            <div class="bg-main p-4 col-12 col-md-5 rounded shadow">
                <li><b>Creation, editing and dismantling of new <u>spaceships</u> carrying Helium 3. Each spacecraft must have the following attributes:</b></li>
                <ul class="second-list">
                    <li>Title</li>
                    <li>Country to which the ship belongs, from the list </li>
                    <li>List of mines from which the ship transports Helium 3 </li>
                    <li>A photo of a spaceship</li>
                </ul>
            </div>
            <div class="bg-main p-4 col-12 col-md-5 rounded shadow">
                <li><b>Creation, editing and deletion of new <u>Country Blocks</u>. Each Block of countries must have the following attributes:</b></li>
                <ul class="second-list">
                    <li>Title</li>
                    <li>List of countries belonging to the Bloc. Each country can participate in only one Block, freely leave it or move to another Block. After the bloc collapses, the countries that were in it become free</li>
                </ul>
            </div>
        </ul>
        <div class="d-flex justify-content-center m-3">
            <h2 class="border-bright p-3 pt-1">Explanations:</h2>
        </div>
        <div class="bg-main col-md-10 p-4 rounded shadow">
            <div>Each mine can be visited by any number of spaceships. Each spaceship can fly to any number of mines. The country of the ship and the mine must match. I.e. a mine of one Party cannot be visited by a ship belonging to another Party. With the emergence of Blocks of Parties, all ships of one Block will be able to visit all mines of the Parties of that Block. When a country leaves the Block, the connections between the different mine/lava pairs of the countries must be automatically broken.</div>
        </div>
    </div>
</div>
</div>

@endsection
