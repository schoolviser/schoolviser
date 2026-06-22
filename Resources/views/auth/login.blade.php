@extends('admin.layouts.auth')

@section('title', 'Login')
    
@section('content')
<div class="authentication-inner row">

  <div class="col-lg-12 text-center py-3 mt-lg-5">
    <a href="https://schoolviser.com" class="app-brand-link">
      <img src="{{ asset(option('school_logo','schoolviser_school_info', 'images/logo-white.svg')) }}" class="img-flud" style="" alt="">
      <small>{{config('schoolviser.version')}}</small>
    </a>
  </div>
  <div class="col-lg-4 offset-lg-4 px-5 py-3 form-holder">
    <div class="card shadow-md rounded-3">
      <div class="card-body">
        
        <form id="formAuthentication" class="mb-3 py-2" method="POST" action="{{ route('login') }}">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label text-muted font-10 text-uppercase">Email or Username</label>
            <input type="text" class="form-control @error('username_email') is-invalid @enderror" id="email" name="username_email" placeholder="Username or Email" value="{{ old('username_email') }}" />
            @error('username_email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
              <label class="form-label text-muted text-uppercase font-10" for="password">Password</label>
              <a href="{{ route('password.request') }}">
                <small class="font-10">Forgot Password?</small>
              </a>
            </div>
            <div class="input-group input-group-merge">
              <input type="password" name="password" id="password"  placeholder="Password" ="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror"/>
              <span class="input-group-text cursor-pointer" id="togglePassword">
                <img src="{{ asset('images/visibility_24dp_666666_FILL0_wght400_GRAD0_opsz24.svg') }}" id="passwordIconOn" alt="Show Password">
                <img src="{{ asset('images/visibility_off_24dp_666666_FILL0_wght400_GRAD0_opsz24.svg') }}" id="passwordIconOff" alt="Hide Password" style="display: none;">
              </span>
              @error('password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
          </div>
          <div class="mb-3">
            <div class="form-check pl-4">
              <input class="form-check-input" type="checkbox" id="remember-me" />
              <label class="form-check-label text-muted font-12" for="remember-me"> Remember Me </label>
            </div>
          </div>
          <div class="mb-3">
            <button class="btn btn-primary rounded-3 w-100" type="submit">Sign in</button>
          </div>
        </form>
        
      </div>
    </div>
  </div>
  <div class="col-lg-12 text-center py-2">
    <a href=""><i class="fa fa-facebook"></i></a>
    <a href=""><i class="fa fa-twitter"></i></a>
    <a href=""><i class="fa fa-youtube"></i></a>
  </div>
</div>
@endsection
