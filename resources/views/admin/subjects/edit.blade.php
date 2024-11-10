@extends(env('ADMIN_LAYOUT'))

@section('module-page-heading', 'Update Subject Details')

@section('module-links')
<a href="{{route('site.settings.subjects')}}">Subjects</a>
@endsection


@section('content')
    <div class="row row-1">
        <div class="col-lg-12">
            @include('admin.includes.alerts.updated')
        </div>
        <form action="{{route('site.settings.subjects.update', ['id' => $subject->id])}}" class="col-lg-8" method="POST">
            @csrf
            <div class="card">
                <div class="card-body row">
                    
                    <div class="col-lg-6 mb-2">
                        <label for="name">Subject Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Subject Name" value="{{ old('name') ?? $subject->name }}" />
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                    </div>

                    <div class="col-lg-6 mb-2">
                        <label for="name">Short Name</label>
                        <input type="text" name="short_name" class="form-control" placeholder="Enter Short Name eg Eng" value="{{ old('short_name') ?? $subject->short_name }}" />
                        <small class="text-danger">{{ $errors->first('short_name') }}</small>
                    </div>

                    <div class="col-lg-6 mb-2">
                        <label for="name">Short Code</label>
                        <input type="text" name="short_code" class="form-control" placeholder="Enter Short Code eg Eng" value="{{ old('short_code') ?? $subject->short_code }}" />
                        <small class="text-danger">{{ $errors->first('short_code') }}</small>
                    </div>

                    <div class="col-lg-6 mb-2">
                        <label for="name">Select Level</label>
                        <select name="level" id="" class="form-control">
                            <option value="o" {{ ($subject->level == 'o') ? 'selected' : '' }}>O Level</option>
                            <option value="a" {{ ($subject->level == 'a') ? 'selected' : '' }}>A Level</option>
                        </select>
                        <small class="text-danger">{{ $errors->first('level') }}</small>
                    </div>
            
                    <div class="col-lg-12 my-3">
                        <button type="submit" class="btn btn-primary btn-md rounded-4 w-100">Save</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection