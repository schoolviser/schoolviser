
@extends(config('schoolviser.admin_layout'))

@section('module-page-heading', 'MTN Momo Settings')

@section('module-page-description', config('schoolviser.school_name'))
@section('module-page-description-right', 'A place to configure all your system configurations.')


@section('where-am-i')
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('settings')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1">Settings</a>
@endsection

@section('module-links')

@endsection


@section('content')
<div class="row">
    <div class="col-lg-2">
        <img src="{{ asset('images/momo.jpg') }}" alt="">
    </div>
    <div class="col-lg-6">

        <!-- API USer & API KEY -->
        <form class="card mb-3" action="{{ route('site.settings.mtn.momo.store') }}" method="POST">
            @csrf
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-12 text-uppercase">
                        <small class="mb-0 p-0 fw-bold">{{ 'MTN Momo User & Key' }}</small>
                    </div>
                </div>
            </div>
            <div class="card-body row">
                <div class="col-lg-12 mb-4">
                    <input type="text" name="momo_api_user" value="{{ old('momo_api_user') ?? $momo->momo_api_user }}" placeholder="Api User" class="form-control">
                </div>
                 <div class="col-lg-12">
                    <input type="text" name="momo_api_key" value="{{ old('momo_api_key') ?? $momo->momo_api_key }}" placeholder="Api Key" class="form-control">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-md btn-primary w-100">Save</button>
            </div>
        </form>

         <div class="card mb-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-12 text-uppercase">
                        <small class="mb-0 p-0 fw-bold">{{ 'API Access Token' }}</small>
                    </div>
                </div>
            </div>
            <div class="card-body row">

                <textarea name="" id="" cols="30" rows="10" readonly>{{ $momo->momo_access_token }}</textarea>

            </div>
            <div class="card-footer">
                <a href="{{ route('site.settings.mtn.momo.generate-token') }}">Generate Access Token</a>
            </div>
        </div>


    </div>
</div>
@endsection
