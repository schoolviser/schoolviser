@php
    $intakes = config('schoolviser.intakes');
@endphp

@extends(config('schoolviser.admin_layout'))

@section('module-page-heading', (config('schoolviser.type','') == 'primary' || config('schoolviser.type','') == 'secondary') ? 'Update Term' : 'Update Intake')

@section('pageheaderDescription', 'Configure your terms')

@section('module-links')
<a href="{{ route('settings.terms') }}">View {{(config('schoolviser.type','') == 'primary' || config('schoolviser.type','') == 'secondary') ? 'Terms' : 'Intakes'}}</a>
@endsection

@section('content')

<div class="row row-1">

 <div class="col-lg-12">
  @include('admin.includes.alerts.updated')
 </div>

 <div class="col-lg-8">
  <div class="card">
    <form action="{{ route('settings.terms.update', ['id' => $term->id]) }}" method="POST" class="row card-body">
      @csrf
     
      <div class="col-lg-4 mb-3">
         <label for="" class="">Year</label>
         <select name="year" id="" class="form-control">
          @for ($i = 0; $i < config('schoolviser.look_back_years', 10); $i++)
          <option value="{{ now()->year + $i }}" {{ ((now()->year + $i) == $term->year) ? 'selected' : '' }}>{{ now()->year + $i }}</option>
          @endfor
        </select>
       </div>
     
      <div class="col-lg-4 mb-3">
        <label for="" class="">{{(config('schoolviser.type','') == 'primary' || config('schoolviser.type','') == 'secondary') ? 'Term' : 'Intake'}}</label>
        <select name="term" id="" class="form-control text-danger rounded-0">
          <option value="1" {{ ($term->term == 1) ? 'selected' : '' }}>{{$intakes[1]}}</option>
          <option value="2" {{ ($term->term == 2) ? 'selected' : '' }}>{{$intakes[2]}}</option>
          <option value="3" {{ ($term->term == 3) ? 'selected' : '' }}>{{$intakes[3]}}</option>
        </select>
      </div>
     
      <div class="col-lg-4 mb-3">
       <label for="start_date">Start Date</label>
       <input type="date" name="start_date" class="form-control" value="{{ old('start_date') ?? $term->start_date }}" >
      </div>
     
      <div class="col-lg-4 mb-3">
       <label for="start_date">End Date</label>
       <input type="date" name="end_date" class="form-control" value="{{ old('end_date') ?? $term->end_date }}" >
      </div>
     
      <div class="col-lg-12 my-5">
       <button type="submit" class="btn btn-md btn-primary w-100 rounded-5">Update</button>
      </div>
     </form>
  </div>
 </div>
</div>

@endsection
