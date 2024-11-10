@extends('dashboard.layouts.empty')

@section('title', 'Licensing')
    
@section('content')
<div class="authentication-inner row">
  <div class="col-lg-4 offset-lg-4 py-3">
    <div class="card shadow-md rounded-3 border-danger">
      <div class="card-body">

        <div class="text-center pb-4">
          <h1 class="font-16">Validate License</h1>
        </div>
        <!-- Logo -->
        <div class="text-center pb-4">
          <a href="index.html" class="app-brand-link gap-2">
            <img src="{{ asset('images/logo.svg') }}" alt="">
              <span>👋</span>
          </a>
        </div>
       
        <form id="licensing" class="mb-3" method="POST" action="{{ route('licensing.validate') }}">
          @csrf
          
          <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
              <label class="form-label text-muted text-uppercase font-10" for="password">License</label>
              <a href="">
                <small class="font-10">Contact Support</small>
              </a>
            </div>
            <div class="input-group input-group-merge">
              <input type="text" name="licence"  placeholder="Licence" class="form-control @error('licence') is-invalid @enderror"/>
              <span class="input-group-text cursor-pointer"><i class="mdi mdi-hide"></i></span>
              @error('licence')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
          </div>
          
          <div class="mb-3">
            <button class="btn btn-primary rounded-5 w-100" type="submit">Sign in</button>
          </div>
        </form>
        
      </div>
    </div>
  </div>
</div>
@endsection
