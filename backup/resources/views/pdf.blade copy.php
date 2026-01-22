<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head> 
<body>
    <div class="row">
        <div class="col-md-1 bg-primary text-center">
            <img src="{{ asset('img/suwa-arana-logo-white.png') }}" alt="" width="90px" height="auto" srcset="">
        </div>
    <h2 class="col-md-7 h2">{{ $title }}</h2>
    <div class="col-md-3 text-right">
        <h2>{{ $date }}</h2></div>
    </div>
    <table border="1" width="100%" class="text-center">
        @php 
        $pt = $ft = $mt = $gt = $ot =0
        @endphp
    @foreach ($floor as $fl)
    @php 
        $p = $f = $m = $g = $o =0;
    @endphp
        <tr>
            <td colspan="4"><h4>{{ $fl->number }}</h4></td>
        </tr>
        <tr>
            @foreach ($fl->rooms as $room)
            @if($loop->iteration==5) </tr><tr> @endif
                <td width="25%">
                    <div class="card-header">{{ $room->room_number }}</div>
                @php 
                $occupancy = $room->occupancy()->whereDate('date','=',$date)->get()->pluck('type');
                @endphp
<div class="btn-group" role="group" aria-label="Basic example">
                @foreach($occupancy as $oc)
                                                            
                @switch($oc)
                    @case('p') @php $p++; @endphp <button  class="btn  bg-success text-white   btn-light  "><i class="fa   fa-solid fa-bed"></i></button> @break
                    @case('m') @php $m++; @endphp <button  class="btn  bg-danger text-white   btn-light  "><i class="fa fa-solid fa-person-dress"></i></button> @break 
                    @case('f') @php $f++; @endphp <button  class="btn  bg-info text-white   btn-light  "><i class="fa fa-solid fa-person"></i></button>@break 
                  
                    @default
                      {{-- @case('g') @php $g++; @endphp <button  class="btn  bg-warning text-white   btn-light  "><i class="fa fa-user-tie"></i></button>@break  --}}
                    @php $o++; @endphp <button  class="btn  bg-warning text-white   btn-light  "><i class="fa fa-user"></i></button>   
                   
                        
                @endswitch 
                @endforeach
</div>
            </td>
            @endforeach
            <tr>
            <td colspan="4">
                @php
                $pt +=$p;$ft +=$f;$mt +=$m;$gt +=$g;$ot +=$o;
                @endphp
                <table border="1" width="100%">
                    <tr>
                        <td width="25%">Child</td>
                        <td width="25%">Mother</td>
                        <td width="25%">Father</td>
                        <td width="25%">Other</td>
                    </tr>
                    <tr>
                        <td>{{ $p }}</td>
                        <td>{{ $m }}</td>
                        <td>{{ $f }}</td>
                        <td>{{ $g+$o }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        </tr>
    @endforeach

    <tr>
        <td colspan="3"></td>
        <td colspan="2">
            <h3>Total Summary Occupancy</h3>
            <table border="1" width="100%">
                <tr>
                    <td>Child</td>
                    <td>Mother</td>
                    <td>Father</td>
                    <td>Other</td>
                </tr>
                <tr>
                    <td>{{ $pt }}</td>
                    <td>{{ $mt }}</td>
                    <td>{{ $ft }}</td>
                    <td>{{ $gt+$ot }}</td>
                </tr>
                <tr>
                    <td colspan="3"> Total Occupancy</td>
                    <td colspan="1">{{ $ot+$pt+$ft+$mt+$gt }} </td>
                </tr>
                <tr> 
                <td colspan="3">Available Rooms</td>
                <td colspan="1"></td>
                </tr>
            </table>
           

        </td>
    </tr>
    </table>
</body>
</html>
