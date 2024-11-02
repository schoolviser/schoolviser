
@extends(config('schoolviser.admin_layout'))

@section('module-page-heading', 'School Info')

@section('pageheaderDescription', 'A place to configure all your system configurations.')

@section('where-am-i')
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('settings')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1">Settings</a>
@endsection

@section('module-links')
    
@endsection
    

@section('content')
<div class="row row-1">

    <div class="col-lg-8">
        <div class="card">
            <form class="card-body row py-5" action="{{route('site.settings.school.info.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
        
                <div class="col-lg-6">
                    <label for="logo">School Logo</label>
                    <input type="file" name="school_logo" id="">
                </div>

                <div class="col-lg-6">
                    <img src="{{ asset($schoolinfo->school_logo ?? 'images/logo-white.svg')  }}" alt="School Logo" class="img-fluid" />
                </div>

                <div class="col-lg-12"><hr></div>
                
                <div class="col-lg-3 mt-lg-3">
                    <p class="m-lg-0">School Name</p>
                </div>
                <div class="col-lg-9 mt-lg-3">
                    <input type="text" name="school_name" value="{{ old('school_name') ?? $schoolinfo->school_name }}" class="form-control" placeholder="Enter school name" />
                </div>

                <div class="col-lg-12">
                    <hr>
                    <h5>Contact Information</h5>
                </div>

                <div class="col-lg-6">
                    <label for="address">Address</label>
                    <input type="text" name="address" placeholder="Your School Address" value="{{ old('address') ?? $schoolinfo->address }}" class="form-control" />
                </div>

                <div class="col-lg-6">
                    <label for="address">Phone</label>
                    <input type="text" name="phone" placeholder="Phone" value="{{ old('phone') ?? $schoolinfo->phone }}" class="form-control" />
                </div>


                <div class="col-lg-12 pt-5">
                    <button type="submit" class="btn btn-primary btn-md w-100 rounded-4">Update</button>
                </div>
                
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-0 p-0">General</h4>
                <div class="list-unstyled">
                    <li><a href="{{route('settings.terms')}}" class="link rounded-1">Terms ~ Intakes</a></li>
                    @if (!(config('schoolviser.type') == 'tertiary'))
                    <li><a href="{{route('settings.clazzs')}}" class="link rounded-1">Classes</a></li>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
