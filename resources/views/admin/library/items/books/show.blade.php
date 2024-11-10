@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Library Book Details')
@section('pageheaderDescription', 'Manage Your Library Books')

@section('pageheader-controls')
<a href="" data-bs-toggle="modal" data-bs-target="#addNewBook" class="px-2 py-1 rounded-4 font-12 border border-primary fw-light text-primary">New Book</a>
@endsection

 @section('content')
 <div class="row mt-2">

  <div class="col-lg-3">
   <img src="{{ asset($book->cover ?? 'images/avator.jpg')  }}" alt="" class="img-fluid w-100 border border-primary" />
  </div>
  <div class="col-lg-9">
   <div class="row">
    <div class="col-lg- 12">
     <div class="table-responsive">
      <table class="table table-hover table-striped table-bordered">
       <thead>
        <th>SN</th>
        <th>Copy Number</th>
        <th>barcode</th>
       </thead>
       <tbody>
        @foreach ($book->copies as $copy)
            <tr>
             <td>{{ $loop->index + 1 }}</td>
             <td>{{ $copy->copy_number }}</td>
             <td>{{ $copy->barcode }}</td>
            </tr>
        @endforeach
       </tbody>
      </table>
     </div>
     
    </div>
   </div>
  </div>
  

 </div>

 
 

 
 @endsection