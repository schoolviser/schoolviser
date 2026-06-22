@php
    $schoolType = dx_config('schoolviser_school_type_'.company()->uuid, null);
    $intakes = config('schoolviser.intakes');

    $termName = ($schoolType == 'primary' || $schoolType == 'secondary') ? 'Terms' : 'Intakes';
@endphp

@extends(config('delxero.dashboard_layout', 'schoolviser::layouts.main_layout'))

@section('module-page-heading', 'Update '.tenantTrans('schoolviser::terms.label').' Details')

@section('module-page-actions')
<a href="{{route('manageterms.index')}}" class="btn btn-sm fw-bold btn-light">View {{ tenantTrans('schoolviser::terms.label_plural') }}</a>
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
        'label' => 'Manage '.tenantTrans('schoolviser::terms.label_plural'),
        'url' => route('manageterms.index')
    ],
    [
        'label' => 'Edit Term',
    ]
    
]" />
@endsection


@section('content')

<x-alert-success />
<x-alert-errors />

<form class="card" action="{{route('manageterms.update', ['id' => $term->uuid])}}" method="POST">
  @csrf
  <div class="card-body row">
    
    <div class="col-lg-6">
        <label for="" class="font-10 text-muted">Year</label>
        <select name="year_id" id="" class="form-control">
          @foreach ($years as $year)
          <option value="{{ $year->id }}" {{ ($year->id == $term->academic_year_id) ? 'selected' : '' }}>{{ $year->name }}</option>
          @endforeach
        </select>
        <small class="text-danger error-year-id">{{ $errors->first('year_id') }}</small>
    </div>

    <div class="col-lg-6">
        <label for="" class="font-10 text-muted">Term</label>
        <select name="term" class="form-control text-danger rounded-0">
          <option value="1" {{ ($term->term == 1) ? 'selected' : '' }}>{{ tenantTrans('schoolviser::terms.one') }}</option>
          <option value="1" {{ ($term->term == 2) ? 'selected' : '' }}>{{ tenantTrans('schoolviser::terms.two') }}</option>
          <option value="1" {{ ($term->term == 3) ? 'selected' : '' }}>{{ tenantTrans('schoolviser::terms.three') }}</option>
        </select>
        <small class="text-danger error-term">{{ $errors->first('term') }}</small>
    </div>

     <div class="col-lg-6 my-3">
        <label for="" class="font-10 text-muted">Start Date</label>
        <input type="date" class="form-control" name="start_date" value="{{old('start_date') ?? $term->start_date}}" />
        <small class="text-danger error-start-date">{{ $errors->first('start_date') }}</small>
      </div>

      <div class="col-lg-6 my-3">
        <label for="" class="font-10 text-muted">Start Date</label>
        <input type="date" class="form-control" name="end_date" value="{{old('end_date') ?? $term->end_date}}" />
        <small class="text-danger error-end-date">{{ $errors->first('end_date') }}</small>
      </div>

      <div class="col-lg-12 my-3">
        <label for="" class="font-10 text-muted">Next Term Start Date</label>
        <input type="date" class="form-control" name="next_term_start_date" value="{{old('next_term_start_date') ?? $term->next_term_start_date}}" />
        <small class="text-danger error-next-term-start-date">{{ $errors->first('next_term_start_date') }}</small>
      </div>
      <div class="col-lg-12 py-3">
        <small class="text-danger error-date-range"></small>
      </div>

      <div class="col-lg-12 my-2">
        <button type="submit" class="btn btn-primary btn-md rounded-5 w-100">Update Term</button>
      </div>

  </div>
</form>
@endsection
