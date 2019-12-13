@extends('admin.layouts.app')

@inject('client', 'App\Models\Client')

@inject('cities', 'App\Models\City')

@inject('districts', 'App\Models\District')

@inject('clients', 'App\Models\Client')

@inject('categories', 'App\Models\Category')

@inject('restaurants', 'App\Models\Restaurant')

{{-- @inject('users', 'App\User') --}}



@section('page_title')
  Admin
@endsection

@section('subject_title')
  Sofra
@endsection

@section('content')
<!-- Main content -->
<section class="content">

<div class="row">

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
              <span class="info-box-icon bg-info">
                  <i class="ion ion-ios-people-outline"></i>
              </span>
              <div class="info-box-content">
                  <span class="info-box-text">Users</span>
                  {{-- <span class="info-box-number">{{ $users->count() }}</span> --}}
              </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
            <span class="info-box-icon bg-info">
               <i class="ion ion-ios-people-outline"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Clients</span>
                <span class="info-box-number">{{ $client->count() }}</span>
            </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
          <span class="info-box-icon bg-red">
              <i class="fas fa-shopping-basket" ></i>
          </span>
          <div class="info-box-content">
              <span class="info-box-text">Orders</span>
              {{-- <span class="info-box-number">{{ $donation_requests->count() }}</span> --}}
          </div>
      </div>
  </div>
  
</div>

<div class="row">

  <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
          <span class="info-box-icon bg-green">
             <i class="fas fa-door-open" ></i>
          </span>
          <div class="info-box-content">
              <span class="info-box-text">Restaurants</span>
              <span class="info-box-number">{{ $restaurants->count() }}</span>
          </div>
      </div>
  </div>

  <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
          <span class="info-box-icon bg-green">
              <i class="fas fa-home" ></i>
          </span>
          <div class="info-box-content">
              <span class="info-box-text">Cities</span>
              <span class="info-box-number">{{ $cities->count() }}</span>
          </div>
      </div>
  </div>

  <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
          <span class="info-box-icon bg-blue"><i class="fas fa-home" ></i></span>
              <div class="info-box-content">
                  <span class="info-box-text">Districts</span>
                  <span class="info-box-number">{{ $districts->count() }}</span>
              </div>
        </div>
  </div>
</div>

<!-- Default box -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Title</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fas fa-minus"></i></button>
      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fas fa-times"></i></button>
    </div>
  </div>
  <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        You are logged in!  
  </div>
  <!-- /.card-body -->
  <div class="card-footer">
    Footer
  </div>
  <!-- /.card-footer-->
</div>
<!-- /.card -->
</section>
<!-- /.content -->

@endsection
