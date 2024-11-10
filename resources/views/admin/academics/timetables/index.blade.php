@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Time Table')
@section('pageheaderDescription', 'Class Timetable')

@section('pageheader-controls')
<a href="" class="px-2 py-1 rounded-4  font-12 border border-primary text-primary" data-bs-target="#addRoutineModal" data-bs-toggle="modal">Add Routine</a>
@endsection
    
@section('content')
@inject('subject', 'App\Models\Academics\Subject')
@inject('stream', 'App\Models\Stream')
@php
    $clazzs = clazzs();
    $subjects = $subject::all();
    $streams = $stream::with(['clazz'])->get();
@endphp

<div class="row mt-3">
  @php
      $clazzs = clazzs();
  @endphp  

  <div class="col-lg-12">
    @foreach ($clazzs as $clazz)
        <a href="{{route('academics.timetable.show', ['id' => $clazz->id])}}" class="font-13 rounded-5 border border-primary bg-white px-2 py-1 ">{{ $clazz->name}}</a>
    @endforeach
  </div>
</div>



<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div
  class="modal fade"
  id="addRoutineModal"
  tabindex="-1"
  data-bs-backdrop="static"
  data-bs-keyboard="false"
  
  role="dialog"
  aria-labelledby="modalTitleId"
  aria-hidden="true"
>
  <div
    class="modal-dialog modal-dialog-scrollable modal-sm"
    role="document"
  >
    <form class="modal-content" method="POST" action="{{route('academics.timetable.routine.store')}}">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title font-13" id="modalTitleId">
          Add Class Routine
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body row">

        <div class="col-lg-12 mb-1">
          <select name="clazz" id="" class="form-control">
            <option value="">Choose Class</option>
            @foreach ($clazzs as $clazz)
                <option value="{{ $clazz->id }}">{{ $clazz->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-lg-12 mb-1">
          <select name="subject" id="" class="form-control">
            <option value="">Choose Subject</option>
            @foreach ($subjects as $subject)
            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-lg-12">
          <select name="stream" id="" class="form-control">
            <option value="">Choose Stream</option>
            @foreach ($streams as $stream)
            <option value="{{ $stream->id }}">{{ $stream->clazz->name.' Stream '.$stream->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-lg-12">
          <select name="day" id="" class="form-control">
            <option value="mon">Monday</option>
            <option value="tue">Tuesday</option>
            <option value="wed">Wednesday</option>
            <option value="thur">Thursday</option>
            <option value="fri">Friday</option>
            <option value="sat">Saturday</option>
            <option value="sun">Sunday</option>
          </select>
        </div>

        <div class="col-lg-6">
          <label for="" class="mb-1 font-10 text-muted fst-italic">Start Time</label>
          <input type="time" name="starting_time" class="form-control" value="{{ old('starting_time') }}" />
        </div>

        <div class="col-lg-6">
          <label for="" class="mb-1 font-10 text-muted fst-italic">End Time</label>
          <input type="time" name="ending_time" class="form-control" value="{{ old('ending_time') }}" />
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
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

@endsection
