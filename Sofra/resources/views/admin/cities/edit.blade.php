@extends('admin.layouts.app')

@section('page_title')
 Edit city
@endsection

@section('content')
<!-- Main content -->
<section class="content">

<!-- Default box -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Edit city</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fas fa-minus"></i></button>
      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fas fa-times"></i></button>
    </div>
  </div>
  <div class="card-body">
    {!! Form::model($model, [
      'action' => ['Admin\CityController@update', $model->id],
      'method' => 'put'
      
    ]) !!}

      @include('admin.partials.validation_errors')
      @include('admin.cities.form')
      <div class="form-group">
        {!! Form::submit('Edit', [
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
