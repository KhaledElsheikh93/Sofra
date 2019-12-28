@extends(('admin.layouts.app'))

@section('page_title')
  Orders
@endsection

@section('content')
<!-- Main content -->
<section class="content">

<!-- Default box -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">List of Orders</h3>

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
                    <th class="text-center">client</th>
                    <th class="text-center">restaurant</th>
                    <th class="text-center">amount</th>
                    <th class="text-center">Special order</th>
                    <th class="text-center">notes</th>
                    <th class="text-center">Payment Method</th>
                    <th class="text-center">Order price</th>
                    <th class="text-center">Total price</th>
                    <th class="text-center">Commission</th>
                    <th class="text-center">Order Status</th> 
                  </tr>
                </thead>
                <tbody>
                  @foreach($records as $record)
                     <tr>
                       <td>{{ $records->perPage()*($records->currentPage()-1)+$loop->iteration }}</td>
                       <td class="text-center">{{ ($record->client)->name }}</td>
                       <td class="text-center">{{ ($record->restaurant)->name }}</td>
                       <td class="text-center">{{ $record->amount }}</td>
                       <td class="text-center">{{ $record->special_order }}</td>
                       <td class="text-center">{{ $record->notes }}</td>
                       <td class="text-center">{{ $record->payment_method }}</td>
                       <td class="text-center">{{ $record->cost }}</td>
                       <td class="text-center">{{ $record->total}}</td>
                       <td class="text-center">{{ $record->commission}}</td>
                       <td class="text-center">{{ $record->state}}</td>
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
