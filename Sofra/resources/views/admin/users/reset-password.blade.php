
@extends('admin.layouts.app')

@section('page_title')
 Change password
@endsection

@section('content')
<!-- Main content -->
<section class="content">

<!-- Default box -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Change {{ auth()->user()->name }} password</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fas fa-minus"></i></button>
      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fas fa-times"></i></button>
    </div>
  </div>
  <div class="card-body">

  {!! Form::open(array('url' => 'admin/users/change-password', 'method' => 'POST')) !!}
  <div class="form-group">
        <label for="email">Old Password</label>
            {!! Form::password('old-password', [
            'class' => 'form-control'
            ]) !!}
    </div>
    <div class="form-group">
        <label for="password">New Password</label>
            {!! Form::password('password', [
            'class' => 'form-control'
            ]) !!}
    </div>
    <div class="form-group">
        <label for="password_confirmation">Password</label>
            {!! Form::password('password_confirmation', [
            'class' => 'form-control'
            ]) !!}
    </div>
      @include('admin.partials.validation_errors')
      
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


   
