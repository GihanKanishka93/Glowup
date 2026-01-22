@extends('layouts.app')
@section('content')
    <h1 class="h3 mb-2 text-gray-800">{{ $occupancy[0]->date }}
       </h1>

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                    <div class="dropdown no-arrow show">
                        <a href="{{ route('occupancy.index') }}" class="btn btn-sm btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">Back</span></a>
                    </div>
                    <div></div>
                </div>

                <div class="card-body">
                    <ul class="list-inline">
                     @foreach($occupancy as $item)
                       <li class="input-group-text">
                        <span class="col-sm-1">
                        @switch($item->type)
                            @case('p') <span class=" badge badge-success user-popup" title="Patient" data-bs-toggle="tooltip"> <i class="fa fa-solid fa-bed float-right"></i> </span> @break
                            @case('f')<span class=" badge badge-info user-popup" data-bs-toggle="tooltip" title="Father"> <i class="fs fa-solid fa-person float-right"></i>  </span> @break
                            @case('m')<span class=" badge badge-danger user-popup" data-bs-toggle="tooltip" title="Mother"> <i class="float-right fa fa-solid fa-person-dress"></i>  </span> @break
                            @case('o')<span class=" badge badge-warning user-popup" data-bs-toggle="tooltip" title="Other"> <i class="fa fa-users float-right"></i> </span> @break
                        @endswitch
                    </span>
                       <span class="col-sm-1 text-right">{{ $item->room->room_number }}  </span>
                      <span class="col-sm-3 text-left"> {{ $item->name }}</span>
                      <div class="col-sm-3 text-right float-right offset-3 text-gray-500">
                     @if($item->updatedUser) Update By {{ $item->updatedUser->first_name.' '.$item->updatedUser->last_name }} at {{ $item->updated_at }}  @else Recorderd By {{ $item->createdUser->first_name.' '.$item->createdUser->last_name }} {{ $item->created_at }} @endif
                    </div>
                    </li>
                     @endforeach
                    </ul>

                    <div class="mb-4">

                        <div class="btn-group " role="group">
                            <button type="button" class="btn bg-success text-white"><span id="child"></span>
                                Child</button>
                            <button type="button" class="btn btn-info"> <span id="father"></span> Father</button>
                            <button type="button" class="btn btn-danger"> <span id="mother"></span> Mother</button>
                            <button type="button" class="btn btn-warning"> <span id="other"></span> Other</button>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>

@endsection

