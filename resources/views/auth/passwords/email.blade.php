@extends('admin.layouts.auth')



@section('content')
<div class="authentication-inner row">
  <div class="col-lg-12 text-center py-3 mt-lg-5">
    <a href="https://schoolviser.com" class="app-brand-link">
      <img src="{{ asset(option('school_logo','schoolviser_school_info', 'images/logo-white.svg')) }}" class="img-flud" style="" alt="">
    </a>
  </div>
   
    <div class="col-lg-4 offset-lg-4 py-3 px-5">
      <div class="card shadow-md">
        <div class="card-body">
          <!-- Logo -->
          <div class="text-start fw-bold">
            <h5>Request For Password Reset</h5>
          </div>

          <form method="POST" action="{{ route('password.email') }}" class="py-3">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label text-muted font-10 text-uppercase">{{ __('E-Mail Address') }}</label>

                <input id="email" type="email" class="form-control my-2 @error('email') is-invalid @enderror" placeholder="Enter Your Email" name="email" value="{{ old('email') }}" required autocomplete="email" />
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 rounded-3 my-4">
                {{ __('Send Password Reset Link') }}
            </button>

            <a href="{{ route('login') }}" class="py-2 text-center">Login Insteady</a>
        </form>
          @if (session('status'))
          <div class="alert alert-success">
            <p class="mb-0">{{ session('status') }}</p>
          </div>
          @endif
          
        </div>
      </div>
    </div>
  </div>

@endsection
