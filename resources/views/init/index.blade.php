@extends('dashboard.layouts.auth')

@section('content')
    <div class="row">
     <div class="col-lg-6 offset-lg-3">
      <div class="card">
       <div class="card-body">
        <div class="text-start pb-4">
         <a href="index.html" class="app-brand-link gap-2">
           <img src="{{ asset('images/logo.svg') }}" alt="">
             <span>👋</span>
         </a>
       </div>
       <h3>Set the current term</h3>
       <p>You can not use schoolviser without setting the current session</p>
        <a href="{{ route('init.set.term') }}" class="btn btn-md btn-primary rounded-4 px-4">Lets Get Started</a>
       </div>
      </div>
     </div>
    </div>
@endsection