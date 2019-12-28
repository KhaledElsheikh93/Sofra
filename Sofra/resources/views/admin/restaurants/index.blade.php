@extends(('admin.layouts.app'))

@section('page_title')
  Restaurants
@endsection

@section('content')
<!-- Main content -->
<section class="content">

<!-- Default box -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">List of restaurants</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fas fa-minus"></i></button>
      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fas fa-times"></i></button>
    </div>
  </div>
  @include('flash::message')
  <div class="card-body">
       @if($records)
          <div class="table-respnosive">
             <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th class="text-center">phone</th>
                    <th class="text-center">email</th>
                    <th class="text-center">name</th>
                    <th class="text-center">district</th>
                    <th class="text-center">delivery charge</th>
                    <th class="text-center">minimum charge</th>
                    <th class="text-center">whats app</th>
                    <th class="text-center">category</th>
                    <th class="text-center">Restaurant payment</th>
                    <th class="text-center">state</th>
                    
                  </tr>
                </thead>
                <tbody>
                  @foreach($records as $record)
                     <tr>
                       <td>{{ $records->perPage()*($records->currentPage()-1)+$loop->iteration }}</td>
                       <td class="text-center">{{ $record->phone }}</td>
                       <td class="text-center">{{ $record->email }}</td>
                       <td class="text-center">{{ $record->name }}</td>
                       <td class="text-center">{{ optional($record->District)->name }}</td>
                       <td class="text-center">{{ $record->delivery_charge }}</td>
                       <td class="text-center">{{ $record->minimum_order }}</td>
                       <td class="text-center">{{ $record->whats }}</td>
                       <td class="text-center">
                        @foreach($record->categories as $cat)
                          <li>{{$cat->name}}</li>
                        @endforeach
                       </td>
                       <td class="text-center">{{ $record->restaurant_payment }}</td>
                       <td class="text-center">{{ $record->state }}</td>  
                               
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
<div>
{{ $records->links() }}
</div>

</div>
<!-- /.card -->
</section>
<!-- /.content -->

@endsection
