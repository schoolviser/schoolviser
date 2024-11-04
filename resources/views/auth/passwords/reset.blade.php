@extends('admin.layouts.auth')

@section('content')
<div class="authentication-inner row">

  <div class="col-lg-12 text-center py-3 mt-lg-5">
    <a href="https://schoolviser.com" class="app-brand-link">
      <img src="{{ asset(option('school_logo','schoolviser_school_info', 'images/logo-white.svg')) }}" class="img-flud" style="" alt="">
    </a>
  </div>

    <div class="col-lg-4 offset-lg-4 py-2 px-5">
      <div class="card shadow-md">
        <div class="card-body">
         
          <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group mb-2">
                <label for="email" class="form-label text-muted font-10 text-uppercase">{{ __('E-Mail Address') }}</label>

                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="password" class="form-label text-muted font-10 text-uppercase">{{ __('Password') }}</label>

                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-2">
                <label for="password-confirm" class="form-label text-muted font-10 text-uppercase">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

            </div>

            <div class="form-group my-2">
                <button type="submit" class="btn btn-primary w-100 rounded-3">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </form>
          
        </div>
      </div>
    </div>
  </div>
@endsection
