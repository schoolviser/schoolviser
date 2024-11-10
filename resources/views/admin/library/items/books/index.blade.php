@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Library Books')
@section('pageheaderDescription', 'Manage Your Library Books')

@section('pageheader-controls')
<a href="" data-bs-toggle="modal" data-bs-target="#addNewBook" class="px-2 py-1 rounded-4 font-12 border border-primary fw-light text-primary">New Book</a>
@endsection

 @section('content')
 <div class="row mt-2">

  <div class="col-lg-12">
    <div class="table-responsive">
      <table class="table table-hover table-striped table-bordered">
        <thead>
          <tr>
            <th style="width: 5%;">SN</th>
            <th style="width: 5%;">...</th>
            <th>Title</th>
            <th>ISBN</th>
            <th>Edition</th>
            <th>Copies</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($books as $book)
          <tr class="">
            <td>{{ $loop->index + 1 }}</td>
            <td class="">
              <img src="{{ asset($book->cover) }}" alt="" class="img-fluid">
            </td>
            <td>
              <a href="{{route('library.items.books.show', ['id' => $book->id])}}" class="font-12 text-primary bg-light p-1 fw-bold">{{ $book->title }}</a>
            </td>
            <td>
              <span class="font-12 text-primary bg-light p-1 fw-bold">{{ $book->isbn ?? $book->issn }}</span>
            </td>
            <td>
              <span class="font-12 text-danger bg-light p-1 fw-light">{{ $book->edition }}</span>
            </td>
            <td>
              <span class="font-12 text-primary bg-light p-1 ">{{ $book->copies_count }}</span>
            </td>
            <td>
              <a href="" class="btn btn-white border border-primary btn-sm rounded-5 px-2 font-12 text-primary">Edit</a>
              <a href="" class="btn btn-white border border-danger btn-sm rounded-5 px-2 font-12 text-danger">Delete</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    
  </div>

 </div>

 
 <!-- Modal Body -->
 <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
 <div
  class="modal fade"
  id="addNewBook"
  tabindex="-1"
  data-bs-backdrop="static"
  data-bs-keyboard="false"
  
  role="dialog"
  aria-labelledby="modalTitleId"
  aria-hidden="true"
 >
  <div
    class="modal-dialog modal-dialog-scrollable modal-md"
    role="document"
  >
    <form class="modal-content" method="POST" action="{{ route('library.items.books.store') }}">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleId">
          Modal title
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body row">
        <div class="col-lg-12">
          <label for="title" class="font-10 text-muted mb-1">Book Title</label>
          <input type="text" name="title" value="{{ old('title') }}" placeholder="Book Title" class="form-control" />
        </div>
        <div class="col-lg-6">
          <label for="author" class="font-10 text-muted mb-1">Author</label>
          <input type="text" name="author" value="{{ old('author') }}" placeholder="Book Author" class="form-control" />
        </div>
        <div class="col-lg-6">
          <label for="isbn" class="font-10 text-muted mb-1">ISBN</label>
          <input type="text" name="isbn" value="{{ old('isbn') }}" placeholder="Book ISBN" class="form-control" />
        </div>
        <div class="col-lg-6">
          <label for="edition" class="font-10 text-muted mb-1">Edition</label>
          <input type="text" name="edition" value="{{ old('edition') }}" placeholder="Book Edition" class="form-control" />
        </div>
        <div class="col-lg-6">
          <label for="copies" class="font-10 text-muted mb-1">No Of Copies</label>
          <input type="text" name="copies" value="{{ old('copies') }}" placeholder="Copies" class="form-control" />
        </div>
      </div>
      <div class="modal-footer">
        <button
          type="button"
          class="btn btn-secondary"
          data-bs-dismiss="modal"
        >
          Close
        </button>
        <button type="submit" class="btn btn-primary rounded-5 w-100">Save</button>
      </div>
    </form>
  </div>
 </div>
 
 <!-- Optional: Place to the bottom of scripts -->
 <script>
  const myModal = new bootstrap.Modal(
    document.getElementById("modalId"),
    options,
  );
 </script>
 
 @endsection