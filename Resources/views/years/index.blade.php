
@extends(config('delxero.dashboard_layout', 'schoolviser::layouts.main_layout'))


@section('module-page-heading', 'Academic Years')

@section('module-page-actions')
<a href="" data-bs-toggle="offcanvas" data-bs-target="#addYear" class="btn btn-sm fw-bold btn-primary">Add Academic Year</a>
<x-dropdown 
  buttonLabel="Other Settings" icon="bi-gear"
  :items="[
      [
          'label' => 'Manage '.tenantTrans('schoolviser::terms.label_plural'),
          'url' => route('manageterms.index'),
      ],
      [
          'label' => 'Term Translations',
          'url' => route('term.translations.index', 'en'),
      ]
  ]"
/>
@endsection

@section('module-breadcrumbs')
<x-ui.breadcrumb :items="[
    [
        'label' => 'Settings',
    ],
    [
        'label' => 'Manage Academic Years',
    ]
]" />
@endsection

@section('content')

<x-alert-success />
<x-alert-errors />

<div class="row mt-3">
  
  @if (count($years))
  <div class="col-lg-12">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="table-responsive card-body">
            <table class="table table-hover align-middle table-row-dashed fs-6 gy-5">

              <thead class="">
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                  <th class="">SN</th>
                  <th>Year</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              
              <tbody>
                  @foreach ($years as $year)
                   <tr class="">
                      <td>{{ $loop->index + 1 }}</td>
                      <td><small class="text-capitalize">{{ $year->name }}</small></td>
                      <td><small class="text-capitalize">{{ $year->start_date }}</small></td>
                      <td><small class="text-capitalize">{{ $year->end_date }}</small></td>
                      <td>
                        <a href="{{route('manageacademicyears.show', ['id' => $year->uuid])}}" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i></a>
                        <a href="{{route('manageacademicyears.show', ['id' => $year->uuid])}}" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                      </td>
                    </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-12 my-2">
      </div>
    </div>
  </div>


  @else

  @endif

  <div class="col-lg-6">
  </div>
</div>


<div
  class="offcanvas offcanvas-start"
  data-bs-scroll="true"
  tabindex="-1"
  id="addYear"
  aria-labelledby="Enable both scrolling & backdrop"
>
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="Enable both scrolling & backdrop">
      Add New Intake
    </h5>
    <button
      type="button"
      class="btn-close"
      data-bs-dismiss="offcanvas"
      aria-label="Close"
    ></button>
  </div>
  <div class="offcanvas-body">
  <form class="card-body row" action="{{ route('manageacademicyears.store') }}" method="POST">
    @csrf
    <div class="col-lg-12 mb-3">
      <label for="" class="font-10 text-muted">Name/Description</label>
      <input type="text" name="name" class="form-control">
    </div>
    <div class="col-lg-12 mb-3">
      <label for="" class="font-10 text-muted">Start Date</label>
      <input type="date" class="form-control" name="start_date" value="{{old('start_date')}}" />
      <small class="text-danger">{{ $errors->first('start_date') }}</small>
    </div>
    <div class="col-lg-12 mb-3">
      <label for="" class="font-10 text-muted">End Date</label>
      <input type="date" class="form-control" name="end_date" value="{{old('end_date')}}" />
      <small class="text-danger">{{ $errors->first('end_date') }}</small>
    </div>

    <div class="col-lg-12 my-2">
      <button type="submit" class="btn btn-primary btn-sm rounded-5 w-100">Save Year</button>
    </div>
  </form>
  </div>
</div>

@endsection
