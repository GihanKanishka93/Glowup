@extends('layouts.app')

@section('content')
   
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="h3 mb-2 text-gray-800">{{ $item->name }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">{{ $item->name }}</li>
            </ol>
          </div>
        </div>
      </div> 
    </section>
 
    <section class="content"> 
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">item</h3> 
        </div>
        <div class="card-body">
          Start creating your amazing application!
        </div> 
        <div class="card-footer">
          Footer
        </div> 
      </div> 

    </section> 
@endsection
