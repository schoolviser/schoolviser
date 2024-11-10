@php
    $intakes = config('schoolviser.intakes');
@endphp

@extends('admin.layouts.auth')

@section('content')
    <div class="row">
     <div class="col-lg-6 offset-lg-3">
      @include('admin.includes.alerts.created')
     </div>
     <div class="col-lg-6 offset-lg-3">

      <div class="card rounded-3">
       <div class="card-body">
        <div class="text-start pb-4">
         <a href="index.html" class="app-brand-link gap-2">
           <img src="{{ asset('images/logo.svg') }}" alt="">
             <span>👋</span>
         </a>
       </div>
       

       @if (term())
       <a href="{{ route('home') }}">Visit Home</a>
       @else
       <h5 class="text-capitalize fw-bold">Set the current {{(config('schoolviser.type','') == 'primary' || config('schoolviser.type','') == 'secondary') ? 'Term' : 'Intake'}}</h5>
       <p>You can not use schoolviser without setting the current session</p>
       <form class="row" action="{{ route('init.set.term.store') }}" method="POST">
        @csrf
        <div class="col-lg-6">
          <label for="" class="font-10 text-muted">Year</label>
          <select name="year" id="" class="form-control">
            @for ($i = 0; $i < config('schoolviser.look_back_years', 10); $i++)
            <option value="{{ now()->year + $i }}">{{ now()->year + $i }}</option>
            @endfor
          </select>
        </div>
        <div class="col-lg-6">
          <label for="" class="font-10 text-muted">{{(config('schoolviser.type','') == 'primary' || config('schoolviser.type','') == 'secondary') ? 'Term' : 'Intake'}}</label>
          <select name="term" id="" class="form-control text-danger rounded-0">
            <option value="1" {{ (old('term') == 1) ? 'selected' : '' }}>{{$intakes[1]}}</option>
            <option value="2" {{ (old('term') == 2) ? 'selected' : '' }}>{{$intakes[2]}}</option>
            <option value="3" {{ (old('term') == 3) ? 'selected' : '' }}>{{$intakes[3]}}</option>
          </select>
        </div>
        <div class="col-lg-6">
          <label for="" class="font-10 text-muted">Start Date</label>
          <input type="date" class="form-control" name="start_date" value="{{old('start_date')}}" />
          <small class="text-danger">{{ $errors->first('start_date') }}</small>
        </div>
        <div class="col-lg-6">
          <label for="" class="font-10 text-muted">Start Date</label>
          <input type="date" class="form-control" name="end_date" value="{{old('end_date')}}" />
          <small class="text-danger">{{ $errors->first('end_date') }}</small>
        </div>
  
        <div class="col-lg-12">
          <label for="" class="font-10 text-muted">Next Term Start Date</label>
          <input type="date" class="form-control" name="next_term_start_date" value="{{old('next_term_start_date')}}" />
          <small class="text-danger">{{ $errors->first('next_term_start_date') }}</small>
        </div>
  
        <div class="col-lg-12 my-2">
          <button type="submit" class="btn btn-primary btn-md rounded-5 w-100">Save Term</button>
        </div>
      </form>
       @endif

       </div>
      </div>
     </div>
    </div>
@endsection