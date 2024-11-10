
@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'Requirements Breakdown')
@section('pageheaderDescription', 'Requirements Breakdown')

@section('pageheader-controls')
<a class="px-3 py-1 rounded-4 bg-light font-12 border border-primary fw-bold text-primary" type="button" data-bs-toggle="modal" data-bs-target="#createRequirementBreakdownModal">Add Requirement Breakdown</a>
<a href="{{ route('fees.structure', ['year' => request('year') ?? term()->year, 'term' => request('term') ?? term()->term ]) }}" class="px-3 py-1 rounded-4 bg-light font-12 border border-primary fw-bold text-primary">View Fees Structure</a>
@endsection

@section('where-am-i')
<a href="{{route('dashboard')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-light text-dark">Fees</a>
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('fees.breakdown', ['year' => request('year') ?? term()->year, 'term' => request('term') ?? term()->term])}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1 text-dark">Fees Particulars</a>
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('accounting.expenses')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1">Year | Term</a>
@endsection
    
@section('content')

<div class="row">

</div>

<div class="row mt-3">
  <div class="col-lg-12">
    @include('dashboard.includes.alerts.created')
  </div>
  <div class="col-lg-12">
    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped">
        <thead>
          <th>SN</th>
          <th>Class</th>
          <th>Day</th>
          <th>Boarding</th>
        </thead>
        <tbody>
          @foreach ($requirementsBreakDowns as $requirementsBreakDown)
            <tr>
              <td style="width: 5%;">{{ $loop->index + 1 }}</td>
              <td>{{ $requirementsBreakDown->clazz->abbr }}</td>
              <td>
                <div class="bg-light w-75 rounded-3 px-3 py-2">
                  <small class="fw-bold">Male (New)</small>
                  @if (count($requirementsBreakDown->requirements->dayMaleNew) > 0)
                      <ul>
                      @foreach ($requirementsBreakDown->requirements->dayMaleNew as $requirement)
                          <li>
                            <small>{{ $requirement->item->name }}</small>
                            <small class="text-primary" style="font-weight: 500;">{{ $requirement->quantity }}</small>
                          </li>
                      @endforeach
                      </ul>
                  @endif
                </div>
                <br />
                <div class="bg-light w-75 rounded-3 px-3 py-2">
                  <small class="fw-bold">Female (New)</small>
                  @if (count($requirementsBreakDown->requirements->dayFemaleNew) > 0)
                      <ul>
                      @foreach ($requirementsBreakDown->requirements->dayFemaleNew as $requirement)
                          <li>
                            <small>{{ $requirement->item->name }}</small>
                            <small class="text-primary" style="font-weight: 500;">{{ $requirement->quantity }}</small>
                          </li>
                      @endforeach
                      </ul>
                  @endif
                </div>
                <br />
                <div class="bg-light w-75 rounded-3 px-3 py-2">
                  <small class="fw-bold">Male (Continuing)</small>
                  @if (count($requirementsBreakDown->requirements->dayMaleContinuing) > 0)
                      <ul>
                      @foreach ($requirementsBreakDown->requirements->dayMaleContinuing as $requirement)
                          <li>
                            <small>{{ $requirement->item->name }}</small>
                            <small class="text-primary" style="font-weight: 500;">{{ $requirement->quantity }}</small>
                          </li>
                      @endforeach
                      </ul>
                  @endif
                </div>
                <br />
                <div class="bg-light w-75 rounded-3 px-3 py-2">
                  <small class="fw-bold">Female (Continuing)</small>
                  @if (count($requirementsBreakDown->requirements->dayFemaleContinuing) > 0)
                      <ul>
                      @foreach ($requirementsBreakDown->requirements->dayFemaleContinuing as $requirement)
                          <li>
                            <small>{{ $requirement->item->name }}</small>
                            <small class="text-primary" style="font-weight: 500;">{{ $requirement->quantity }}</small>
                          </li>
                      @endforeach
                      </ul>
                  @endif
                </div>
                <br />
                
              </td>
              <td>
                <div class="bg-light w-75 rounded-3 px-3 py-2">
                  <small class="fw-bold">Male (New)</small>
                  @if (count($requirementsBreakDown->requirements->boardingMaleNew) > 0)
                      <ul>
                      @foreach ($requirementsBreakDown->requirements->boardingMaleNew as $requirement)
                          <li>
                            <small>{{ $requirement->item->name }}</small>
                            <small class="text-primary" style="font-weight: 500;">{{ $requirement->quantity }}</small>
                          </li>
                      @endforeach
                      </ul>
                  @endif
                </div>
                <br />
                <div class="bg-light w-75 rounded-3 px-3 py-2">
                  <small class="fw-bold">Female (New)</small>
                  @if (count($requirementsBreakDown->requirements->boardingFemaleNew) > 0)
                      <ul>
                      @foreach ($requirementsBreakDown->requirements->boardingFemaleNew as $requirement)
                          <li>
                            <small>{{ $requirement->item->name }}</small>
                            <small class="text-primary" style="font-weight: 500;">{{ $requirement->quantity }}</small>
                          </li>
                      @endforeach
                      </ul>
                  @endif
                </div>
                <br />
                <div class="bg-light w-75 rounded-3 px-3 py-2">
                  <small class="fw-bold">Male (Continuing)</small>
                  @if (count($requirementsBreakDown->requirements->boardingMaleContinuing) > 0)
                      <ul>
                      @foreach ($requirementsBreakDown->requirements->boardingMaleContinuing as $requirement)
                          <li>
                            <small>{{ $requirement->item->name }}</small>
                            <small class="text-primary" style="font-weight: 500;">{{ $requirement->quantity }}</small>
                          </li>
                      @endforeach
                      </ul>
                  @endif
                </div>
                <br />

                <div class="bg-light w-75 rounded-3 px-3 py-2">
                  <small class="fw-bold">Female (Continuing)</small>
                  @if (count($requirementsBreakDown->requirements->boardingFemaleContinuing) > 0)
                      <ul>
                      @foreach ($requirementsBreakDown->requirements->boardingFemaleContinuing as $requirement)
                          <li>
                            <small>{{ $requirement->item->name }}</small>
                            <small class="text-primary" style="font-weight: 500;">{{ $requirement->quantity }}</small>
                          </li>
                      @endforeach
                      </ul>
                  @endif
                </div>
                <br />
                
                
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>


<div id="createRequirementBreakdownModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="modal-content" action="{{ route('fees.breakdown.store') }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="my-modal-title">Create Requirement</h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body row">
        <div class="col-lg-6">
          <label for="year" class="text-small text-muted">Year</label>
          <input type="text" name="year" class="form-control" value="{{ term()->year }}" readonly />
        </div>
        <div class="col-lg-6">
          <label for="term" class="text-muted text-small">Term</label>
          <input type="text" name="term" class="form-control" value="{{ term()->term }}" readonly />
        </div>

        <div class="col-lg-6">
          @inject('feesCategories', '\App\Models\Fee\FeeCategory')
          <label for="term" class="text-muted text-small">Fee</label>
          <select name="fee_category_id" id="" class="form-control">
            @foreach ($feesCategories->all() as $category)
              <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-lg-6">
          <label for="amount" class="text-muted text-small">Amount</label>
          <input type="text" name="amount" class="form-control" value="{{ old('amount') }}" />
        </div>
        
        <div class="col-lg-6">
          <label for="residence" class="text-small text-muted">Residence</label>
          <select name="residence" id="" class="form-control">
            <option value="boarding">Boarding</option>
            <option value="day">Day</option>
          </select>
        </div>

        <div class="col-lg-6">
          <label for="new_or_continuing" class="text-small text-muted">Entry Status</label>
          <select name="new_or_continuing" id="" class="form-control">
            <option value="new">New</option>
            <option value="continuing">Continuing</option>
          </select>
        </div>

        <div class="col-lg-6">
          <label for="gender" class="text-small text-muted">Gender</label>
          <select name="gender" id="" class="form-control">
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>

        <div class="col-lg-6">
          <label for="class" class="text-muted text-small">Class</label>
          <select class="form-control" name="clazz_id">
            @foreach (clazzs() as $clazz)
                <option value="{{ $clazz->id }}">{{ $clazz->name }}</option>
            @endforeach
          </select>
        </div>




      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-primary">Create</button>
      </div>
    </form>
  </div>
</div>

@endsection
