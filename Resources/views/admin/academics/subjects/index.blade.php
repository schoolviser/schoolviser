@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Subjects')
@section('pageheaderDescription', '')

@section('pageheader-controls')
<a href="" class="px-2 py-1 rounded-4  font-12 border border-primary text-primary" data-bs-target="#addSubjectModal" data-bs-toggle="modal">Add Subject</a>
@endsection
    
@section('content')
<div class="row mt-3">

  <div class="col-lg-12">
    @include('dashboard.includes.alerts.created')
    @include('dashboard.includes.alerts.deleted')
    @include('dashboard.includes.alerts.updated')
  </div>

  <div class="col-lg-8">
    <div class="table-responsive">
      
      <table class="table table-striped table-hover table-bordered">
        <thead>
          <th>SN</th>
          <th>Subject</th>
          <th>Level</th>
        </thead>
        <tbody>
          @foreach ($subjects as $subject)
              <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>
                  <span>{{ $subject->name }}</span>
                </td>
                <td>
                  <span class="text-capitalize">{{ $subject->level.' Level' }}</span>
                </td>
                <td>
                  <a href="{{ route('settings.academics.subjects.show', ['id' => $subject->id]) }}" class="btn btn-sm btn-primary px-3 rounded-5 font-13">Details</a>
                  <a href="{{ route('settings.academics.subjects.destroy', ['id' => $subject->id]) }}" class="btn btn-sm btn-danger px-3 rounded-5 font-13">Delete</a>
                </td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    
  </div>
</div>



<!-- Modal Body -->
<div
  class="modal fade"
  id="addSubjectModal"
  tabindex="-1"
  data-bs-backdrop="static"
  data-bs-keyboard="false"
  
  role="dialog"
  aria-labelledby="modalTitleId"
  aria-hidden="true"
>
  <div
    class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
    role="document"
  >
    <form class="modal-content" action="{{ route('settings.academics.subjects.store') }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title font-13" id="modalTitleId">
          Add New Subject
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
          <label for="name" class="font-10 mb-1 text-muted">Subject Name</label>
          <input type="text" name="name" class="form-control" placeholder="Subject Name" value="{{ old('name') }}" />
          <small class="text-danger font-10">{{ $errors->first('name') }}</small>
        </div>

        <div class="col-lg-12">
          <label for="level" class="font-10 mb-1 text-muted">Level</label>
          <select name="level" id="" class="form-control">
            <option value="">Choose Level</option>
            <option value="o">Ordinary Level</option>
            <option value="a">Advanced Level</option>
          </select>
        </div>

        <div class="col-lg-12 my-2">
          <div class="form-check">
            <input class="form-check-input" name="core" type="checkbox" value="1" id="" />
            <label class="form-check-label" for=""> Is Core Subject </label>
          </div>
          
        </div>

      </div>
      <div class="modal-footer">
        <button
          type="button"
          class="btn btn-secondary rounded-5 px-4"
          data-bs-dismiss="modal"
        >
          Close
        </button>
        <button type="subject" class="btn btn-primary rounded-5 px-4">Save</button>
      </div>
    </form>
  </div>
</div>


@endsection
