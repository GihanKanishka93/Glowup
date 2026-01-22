@extends('layouts.app')

@section('content')
@extends('layouts.loading')
    <div class="card">
        <div class="card-header row">
            <h3 class="col-md-8">Daily Room Occupancy</h3>

            <form action="" id="select_date" method="get" class="col-md-3 float-right">
                @csrf
                <select name="date" class="form-control form-select" id="date">
                    @foreach ($dates as $da)
                        <option value="{{ $da->date }}"
                            @if ($date == $da->date) @selected(true) @endif>{{ $da->date }}
                        </option>
                    @endforeach
                </select>
            </form>
            <form action="{{ route('print') }}" method="get" target="new">
                <input type="hidden" value="{{ $date }}" name="date">
                <input type="submit" value="Print" class="btn btn-sm btn-primary">
            </form>

        </div>

        <div class="alert alert-secondary" role="alert">
            <i style="text-transform: none;">Attention: The following information is based on Room Occupancy input. Please note this when interpreting the data.</i>
          </div>

        <div class="card">
            <div class="card-body text-info">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xl-6">
                        <dl class="row">
                            <dd class="col-md-10 text-right"><h2 class="text-right"><u>{{ $date }}</u></h2></dd>
                            <dd class="col-md-10 text-right">Room Occupancy Previous Day ({{ $yesterday }})</dd>
                            <dt class="col-md-2">{{ $YesterdayOccupancy }}</dt>
                            <dd class="col-md-10 text-right">New Admission </dd>
                            <dt class="col-md-2">{{ $newAdmission }}</dt>
                            <dd class="col-md-10 text-right">Discharges </dd>
                            <dt class="col-md-2">{{ $discharge }}</dt>
                            <dd class="col-md-10 text-right">Room Occupancy </dd>
                            <dt class="col-md-2" id="occ_room"><i class="fa-solid fa-spinner fa-spin"></i></dt>
                        </dl>
                    </div>
                    <div class="col-sm-12 col-md-12 col-xl-6">
                        <div class="text-right">
                            <h2 class="">Total Summary Occupancy</h2>
                            <div class="btn-group " role="group">
                                <button type="button" class="btn bg-success text-white"><span id="child"><i class="fa-solid fa-spinner fa-spin"></i></span>
                                    Child</button>
                                <button type="button" class="btn btn-info"> <span id="father"><i class="fa-solid fa-spinner fa-spin"></i></span> Father</button>
                                <button type="button" class="btn btn-danger"> <span id="mother"><i class="fa-solid fa-spinner fa-spin"></i></span> Mother</button>
                                <button type="button" class="btn btn-warning"> <span id="other"><i class="fa-solid fa-spinner fa-spin"></i></span> Other</button>
                            </div>
                        </div>
                        <br />
                        <div class="col-md-12">
                            <dl class="row">
                                <dd class="col-md-10 text-right">Total Occupancy</dd>
                                <dt class="col-md-2">
                                    <h3><span id="total"><i class="fa-solid fa-spinner fa-spin"></i></span>  </h3>
                                </dt>
                                <dd class="col-md-10 text-right">Available Rooms</dd>
                                <dt class="col-md-2">
                                    <h3 id="abl_room"><i class="fa-solid fa-spinner fa-spin"></i></h3>
                                </dt>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <br />
        @php  $pt = $ft = $mt = $gt = $ot = $abl_room = 0;  @endphp
        @foreach ($floor as $item)
            @php
                $p = $f = $m = $o = 0;
            @endphp
            <div class="col-md-12 row">
                <div class="col-sm-12">
                    <div class="card text-dark  mb-3">

                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h2 class="card-title"> {{ $item->number }} </h2>
                            @foreach ($item->rooms as $room)
                                @php $occupancy = $room->occupancy()->whereDate('date','=',$date)->get()->pluck('type'); @endphp
                                @if(count($occupancy)==0) @php $abl_room++ @endphp  @endif
                                @foreach ($occupancy as $oc)
                                    @switch($oc)
                                        @case('p') @php $p++; @endphp   @break
                                        @case('m')  @php $m++; @endphp  @break
                                        @case('f') @php $f++; @endphp  @break

                                        @case('g')
                                        @case('o')  @php $o++; @endphp @break

                                        @default
                                    @endswitch
                                @endforeach

                            @endforeach
                            @php
                                    $pt += $p;
                                    $ft += $f;
                                    $mt += $m;
                                    $ot += $o;
                                @endphp
                            <div class="card-tool float-right">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn bg-success text-white">{{ $p }}
                                        Child</button>
                                    <button type="button" class="btn btn-info">{{ $f }} Father</button>
                                    <button type="button" class="btn btn-danger">{{ $m }} Mother</button>
                                    <button type="button" class="btn btn-warning">{{ $o }} Other</button>
                                    <button class="  btn btn-outline-dark">=</button>
                                    <button type="button" class="btn btn-primary">{{ $o + $p + $f + $m }} Total</button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body row ">

                            @foreach ($item->rooms as $room)
                                <div class=" col-xl-3 col-md-6 col-sm-12 mb-sm-2 mb-md-2">
                                    <div class="card text-dark ">
                                        <div class="card-header h3 bold text-purple">Room {{ $room->room_number }}</div>
                                        <div class="card-body card-bg-img text-lg-center text-md-center text-sm-center">
                                            @php
                                                $occupancy = $room
                                                    ->occupancy()
                                                    ->whereDate('date', '=', $date)
                                                    ->get()
                                                    ->map(function ($item) {
                                                        return $item->type . ' | ' . $item->name;
                                                    });
                                            @endphp

                                            <div class="btn-group person-button" role="group"
                                                aria-label="Basic example">
                                                @foreach ($occupancy as $oc)
                                                @php
                                                    $o = explode(' | ' ,$oc);
                                                @endphp
                                                    @switch($o[0])
                                                        @case('p')
                                                            <button data-bs-toggle="tooltip" title="{{ $o[1] }}" class="btn  bg-success text-white   btn-light  "><i
                                                                    class="fa   fa-solid fa-bed"></i></button>
                                                        @break

                                                        @case('m')
                                                            <button  data-bs-toggle="tooltip" title="{{ $o[1] }}" class="btn  bg-danger text-white   btn-light  "><i
                                                                    class="fa fa-solid fa-person-dress"></i></button>
                                                        @break

                                                        @case('f')
                                                            <button data-bs-toggle="tooltip" title="{{ $o[1] }}" class="btn  bg-info text-white   btn-light  "><i
                                                                    class="fa fa-solid fa-person"></i></button>
                                                        @break

                                                        @case('g')
                                                        @case('o')
                                                            <button data-bs-toggle="tooltip" title="{{ $o[1] }}" class="btn  bg-warning text-white   btn-light  "><i
                                                                    class="fa fa-user"></i></button>
                                                        @break

                                                        @default
                                                    @endswitch
                                                @endforeach

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('third_party_stylesheets')
<style>
    .card-bg-img{
        background-color: #ffff2f;
        background-image: url('img/room.jpeg');
        background-size: cover;
    min-height: 300px;

    }
    .card-bg-img::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(225, 225, 225, 34%); /* 0.5 sets the opacity to 50% */
}

.person-button{
    /* position:absolute; */
    top:100%;
    align-content: center;
    z-index:5;
    max-width:100%;
    padding:.25rem .5rem;
    margin-top:-1.9rem;
    font-size:.875rem;
    line-height:1.5;
    color:#fff;
    background-color:rgb(116 198 185);
    border-radius:.35rem
}

</style>

@endsection

@section('third_party_scripts')
    <script>


        $('#date').change(function() {
            $("#loading-container").show();
       $('#loading-spinner').show();
            $('#select_date').submit();
        });

        setTimeout(function() {
        $('#child').text({{ $pt }});
        $('#mother').text({{ $mt }});
        $('#father').text({{ $ft }});
        $('#other').text({{ $ot }});
        $('#total').text({{ $ot+$pt+$mt+$ft }});
        $('#abl_room').text({{ $abl_room }});

        $('#occ_room').text({{ 32-$abl_room }});
        $('#loading-spinner').hide();
        $("#loading-container").hide();
    }, 10000); // Example delay of 2 seconds, adjust as needed

    </script>

@endsection
