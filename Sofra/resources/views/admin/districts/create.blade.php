@extends('admin.layouts.app')

@inject('model', 'App\Models\District')
@inject('city', 'App\Models\City')

@section('page_title')
  Add New District
@endsection

@section('content')
<!-- Main content -->
<section class="content">

<!-- Default box -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Add district</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fas fa-minus"></i></button>
      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fas fa-times"></i></button>
    </div>
  </div>
  @include('flash::message')
  <div class="card-body">
      {!! Form::model($model, [
         'action' => 'Admin\DistrictController@store'
      ]) !!}
      @include('admin.partials.validation_errors')
      @include('admin.districts.form')
      <div class="form-group">
          <label for="city">City name</label>
          <select name="city_id">
            @foreach($cities as $city)
                <option value="{{$city->id}}">{{$city->name}}</option>
            @endforeach
          </select> 
      </div> 
      <div class="form-group">
      {!! Form::submit('Add', [
             'class' => 'btn btn-primary'
       ]) !!}
       </div>

       {!! Form::close() !!}
  </div>
  <!-- /.card-body -->


</div>
<!-- /.card -->
</section>
<!-- /.content -->

@endsection
