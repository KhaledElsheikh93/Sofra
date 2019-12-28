@extends('admin.layouts.app')

@inject('model', 'App\User')

@section('page_title')
 Create User
@endsection

@section('content')
<!-- Main content -->
<section class="content">

<!-- Default box -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Add User</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fas fa-minus"></i></button>
      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fas fa-times"></i></button>
    </div>
  </div>
  <div class="card-body">
    {!! Form::model($model, [
      'action' => 'Admin\UserController@store',
      'method' => 'post'
    ]) !!}

      @include('admin.partials.validation_errors')
      @include('admin.users.form')

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
