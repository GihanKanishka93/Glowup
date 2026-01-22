@extends('layouts.app')

@section('content')
    
<h1 class="h3 mb-2 text-gray-800">Modify Room Details</h1>
    <div class="row">
      <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                <div class="dropdown no-arrow show">
                    <a href="{{ route('room.index') }}" class="btn btn-sm btn-info btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fa fa-arrow-left"></i>
                        </span>
                        <span class="text">Back</span></a>
                </div>
            </div>
            <div class="card-body">

                <dl class="row">
                    <dt class="col-sm-4">Room Number</dt>
                    <dd class="col-sm-8">{{ $room->room_number }}</dd>
                    <dt class="col-sm-4">Floor</dt>
                    <dd class="col-sm-8">{{ $room->floor->number }}</dd>
                    <dt class="col-sm-4">Room Status </dt>
                    <dd class="col-sm-8">
                      @php switch($room->status){
                        case 1: $st = 'Available (Inventory Complete)'; break;
                        case 2: $st = 'Available (Inventory Incomplete)'; break;
                        case 20: $st = 'Occupied'; break;
                        case 30: $st = 'Under Maintenance'; break;
                        default : $st = 'N/A'; break;
                    }
                    @endphp
                    {{ $st }}
                    </dd>
                    <dt class="col-sm-4">Inventory</dt>
                    <dd class="col-sm-8">
                        <ul>
                            
                        @foreach ($room->item as $item)
                         <li>   {{ $item->name }}</li>
                        @endforeach

                    </ul>

                    </dd>



                </dl>

            </div>
            </div>
        </div>

    </div>
@endsection
