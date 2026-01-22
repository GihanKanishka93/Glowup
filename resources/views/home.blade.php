@extends('layouts.app')

@section('content')
@extends('layouts.loading')
    <div class="card">







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

                                </div>
                            </div>
                        </div>

                        <div class="card-body row ">

                            @foreach ($item->rooms as $room)

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
