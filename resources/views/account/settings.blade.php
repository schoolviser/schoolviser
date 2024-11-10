@extends('dashboard.layouts.master')

@section('pageheader', 'Your Account Settings')

@section('pageheader-controls')
@endsection
    
@section('content')
<div class="row">
  <div class="col-12 grid-margin table-card">
    <div class="card">
      <form action="{{ route('account.settings.update') }}" method="POST" class="card-body m-1 row">
        @csrf
        <div class="col-lg-3">
          <label for="displayStyle">System Display Style</label>
          <select name="display_style" id="displayStyle" class="form-control">
            <option value="vertical" {{ (option(auth()->user()->id.'_display_style') == 'vertical') ? 'selected' : '' }}>Vertical</option>
            <option value="horizontal" {{ (option(auth()->user()->id.'_display_style') == 'horizontal') ? 'selected' : '' }}>Horizontal</option>
          </select>
        </div>

        <div class="col-lg-12">
          <button type="submit" class="btn btn-primary btn-md">Update</button>
        </div>

      </form>
    </div>
  </div>
</div>
@endsection
