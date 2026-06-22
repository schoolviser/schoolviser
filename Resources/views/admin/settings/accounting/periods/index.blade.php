@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Accounting Periods')
@section('title', 'Accounting Periods')
@section('pageheaderDescription', 'Manage Accounting Periods')


@section('pageheader-controls')
@endsection

@section('where-am-i')
<a href="{{route('dashboard')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-light text-dark">Dashboard</a>
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('settings')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1">Settings</a>
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1">Accounting</a>
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">Fiscal Years</a>
@endsection

@section('content')

<div class="row mt-3">

  <div class="col-lg-12">
    @include('dashboard.includes.alerts.created')
    @include('dashboard.includes.alerts.deleted')
    @include('dashboard.includes.alerts.updated')
  </div>
  
  <div class="col-lg-6">
    <div class="row">
      <div class="col-lg-12">
        <div
          class="alert alert-primary alert-dismissible fade show"
          role="alert"
        >
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
          ></button>
          An accounting period is an established range of time during which accounting functions are performed, aggregated, and analyzed
        </div>
        
      </div>
      @foreach ($periods as $period)
          <div class="col-lg-6">
            <div class="card mb-lg-2 rounded-4 {{ (period()->id == $period->id) ? 'border-primary shadow-sm' : 'border-dark' }}">
              <div class="card-body row">
                <div class="col-lg-2"><i class="mdi mdi-calendar"></i></div>
                <div class="col-lg-10 bg-light py-2 rounded">
                  <h5 class="mb-0 font-16">{{ $period->name }}</h5>
                </div>
                <div class="col-lg-12">
                  <small class=""><span>Start Date</span> {{ $period->start_date }}</small>
                </div>
                <div class="col-lg-12">
                  <small class=""><span>End Date</span> {{ $period->end_date }}</small>
                </div>
              </div>
              <div class="card-footer">
                <a href="" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="{{ '#updatePeriodModal'.$period->id }}"><i class="mdi mdi-pen font-16"></i></a>
                <a href="{{ route('settings.accounting.period.settings', ['id' => $period->id]) }}" class="btn btn-sm btn-light"><i class="mdi mdi-settings font-16"></i></a>
              </div>
            </div>
          </div>
          <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
          <div
            class="modal fade"
            id="{{ 'updatePeriodModal'.$period->id }}"
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
              <form class="modal-content" method="POST" action="{{ route('settings.accounting.periods.update', ['id' => $period->id]) }}">
                @csrf
                <div class="modal-header">
                  <h6 class="modal-title mb-0" id="modalTitleId">
                    Update Period
                  </h6>
                  <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                  ></button>
                </div>
                <div class="modal-body">
                  <label for="name" class="text-small">Accounting Period Name</label>
                  <input type="text" name="name" class="form-control" value="{{ old('name') ?? $period->name }}" />
                  <small class="text-danger text-small">{{ $errors->first('name') }}</small><br />
          
                  <label for="startDate" class="text-small">Start Date</label>
                  <input type="date" class="form-control" name="start_date" id="startDate" value="{{ old('start_date') ?? $period->start_date }}" />
                  <small class="text-danger text-small">{{ $errors->first('start_date') }}</small><br />
          
                  <label for="endDate" class="text-small">End Date</label>
                  <input type="date" name="end_date" id="endDate" class="form-control" value="{{ old('end_date') ?? $period->end_date }}" />
                  <small class="text-danger text-small">{{ $errors->first('end_date') }}</small>
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
          
          
      @endforeach
    </div>
    
  </div>

  <div class="col-lg-3 offset-lg-3">
    <div class="card rounded-4">
      <form class="" action="{{ route('settings.accounting.periods.store') }}" method="POST">
        @csrf
  
        <div class="card-body">
          <label for="name" class="text-small">Accounting Period Name</label>
          <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
          <small class="text-danger text-small">{{ $errors->first('name') }}</small><br />
  
          <label for="startDate" class="text-small">Start Date</label>
          <input type="date" class="form-control" name="start_date" id="startDate" value="{{ old('start_date') }}" />
          <small class="text-danger text-small">{{ $errors->first('start_date') }}</small><br />
  
          <label for="endDate" class="text-small">End Date</label>
          <input type="date" name="end_date" id="endDate" class="form-control" value="{{ old('end_date') }}" />
          <small class="text-danger text-small">{{ $errors->first('end_date') }}</small>
        </div>
  
        <div class="card-footer">
          <button type="submit" class="btn btn-md btn-primary">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="createAccountingPeriodModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    
  </div>
</div>
@endsection
