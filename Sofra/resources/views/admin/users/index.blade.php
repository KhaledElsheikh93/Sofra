@extends('admin.layouts.app')

@section('page_title')
  Users
@endsection

@section('content')
<!-- Main content -->
<section class="content">

<!-- Default box -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">List of usere</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fas fa-minus"></i></button>
      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fas fa-times"></i></button>
    </div>
  </div>
  @include('flash::message')
  <div class="card-body">
       <a href="{{ url(route('users.create')) }}" class="btn btn-primary">
         <i class="fa fa-plus"></i> New user</a>
        
       @if(count($records))
          <div class="table-respnosive">
             <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">role</th>
                    <th class="text-center">Edit</th>
                    <th class="text-center">Delete</th>
                   
                  </tr>
                </thead>
                <tbody>
                  @foreach($records as $record)
                     <tr>
                       <td>{{ $loop->iteration}}</td>
                       <td class="text-center">{{ $record->name}}</td>
                       <td class="text-center">{{ $record->email}}</td>
                       <td class="text-center">{{ $record->phone}}</td>
                       <td>
                       @foreach($record->roles as $role)
                       <span class="col-lg-6 role">{{ $role->display_name}}</span>
                       @endforeach
                       </td>
                       <td class="text-center">
                          <a href="{{ url(route('users.edit', $record->id)) }}" class="btn btn-success btn-xs">
                              <i class="fa fa-edit"></i> 
                              Edit
                          </a>
                       </td>
                       <td class="text-center">
                         {!! Form::open([
                            'action' => ['Admin\UserController@destroy', $record->id],
                            'method' => 'delete'
                         ]) !!}
                         <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?',this,'red')" >
                            <i class="fa af-trash-o"></i>
                            Delete
                          </button>
                         {!! Form::close() !!}
                       </td>
                     </tr>
                  @endforeach
                </tbody>
             </table>
          </div>
          <div class="text-center">
          {!! $records->render() !!}
          </div>
          @else
            <div class="alert alert-danger" role="alert">
                    No data
                </div>
       @endif
  </div>
  <!-- /.card-body -->


</div>
<!-- /.card -->
</section>
<!-- /.content -->

@endsection
