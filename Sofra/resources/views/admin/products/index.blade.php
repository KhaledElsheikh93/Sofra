@extends('admin.layouts.app')

@section('page_title')
  Products
@endsection

@section('content')
<!-- Main content -->
<section class="content">

<!-- Default box -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">List of Products</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fas fa-minus"></i></button>
      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fas fa-times"></i></button>
    </div>
  </div>
  @include('flash::message')
  <div class="card-body">
       <a href="{{ url(route('products.create')) }}" class="btn btn-primary">
         <i class="fa fa-plus"></i> New Product</a>
        
       @if($records)
          <div class="table-respnosive">
             <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Offering price</th>
                    <th class="text-center">Duration</th>
                    <th class="text-center">Restaurant</th>
                    <th class="text-center">Edit</th>
                    <th class="text-center">Delete</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($records as $record)
                     <tr>
                       <td>{{ $loop->iteration}}</td>
                       <td class="text-center">{{ $record->name}}</td>
                       <td class="text-center">{{ $record->description}}</td>
                       <td class="text-center">{{ $record->price}}</td>
                       <td class="text-center">{{ $record->offering_price}}</td>
                       <td class="text-center">{{ $record->duration}}</td>
                       <td class="text-center">{{ optional($record->Restaurant)->name}}</td>
                       <td class="text-center">
                          <a href="{{ url(route('products.edit', $record->id)) }}" class="btn btn-success btn-xs">
                              <i class="fa fa-edit"></i> 
                              Edit
                          </a>
                       </td>
                       <td class="text-center">
                         {!! Form::open([
                            'action' => ['Admin\ProductController@destroy', $record->id],
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
