@extends(env('ADMIN_LAYOUT'))

@section('module-page-heading', 'Subjects')

@section('pageheaderDescription', 'Configure Your Subjects');

@section('module-links')
<a href="" data-bs-toggle="offcanvas" data-bs-target="#Id1">Add Subject</a>
@endsection

@section('content')

<div class="row row-1">
    <div class="col-lg-12">
        @include('admin.includes.alerts.created')
    </div>

    <div class="col-lg-8">
        <div class="card rounded-3 mb-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-6 text-uppercase">
                        <small class="mb-0 p-0 fw-bold">{{ 'Subjects' }}</small>
                    </div>
                    <div class="col-lg-6 text-end"><small>Action Icons</small></div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table  table-striped">
                    <thead>
                        <th>ID</th>
                        <th>name</th>
                        <th>Short Code</th>
                        <th>Level</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($subjects as $subject)
                        <tr class="">
                            <td>{{ $subject->id }}</td>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->short_code }}</td>
                            <td class="text-uppercase">{{ $subject->level }}</td>
                            <th>
                                <a href="{{route('site.settings.subjects.edit',['id'=>$subject->id])}}" class="btn btn-primary btn-sm"><fa class="fa fa-edit"></fa></a>
                                <a href="" class="btn btn-danger btn-sm"><fa class="fa fa-trash"></fa></a>
                            </th>
                        </tr>
                        @endforeach
                       
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $subjects->links() }}
            </div>
        </div>
        
    </div>
</div>

<div
    class="offcanvas offcanvas-start"
    data-bs-scroll="true"
    tabindex="-1"
    id="Id1"
    aria-labelledby="Enable both scrolling & backdrop"
>
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="Enable both scrolling & backdrop">
            New Subject
        </h5>
        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>
    </div>
    <div class="offcanvas-body">
       <form action="{{route('site.settings.subjects.store')}}" method="POST" class="row">
        @csrf

        <div class="col-lg-6">
            <label for="name">Subject Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter Subject Name" value="{{ old('name') }}" />
            <small class="text-danger">{{ $errors->first('name') }}</small>
        </div>

        <div class="col-lg-6">
            <label for="name">Short Name</label>
            <input type="text" name="short_name" class="form-control" placeholder="Enter Short Name eg Eng" value="{{ old('short_name') }}" />
            <small class="text-danger">{{ $errors->first('short_name') }}</small>
        </div>

        <div class="col-lg-6">
            <label for="name">Short Code</label>
            <input type="text" name="short_code" class="form-control" placeholder="Enter Short Code eg Eng" value="{{ old('short_code') }}" />
            <small class="text-danger">{{ $errors->first('short_code') }}</small>
        </div>

        <div class="col-lg-6">
            <label for="name">Select Level</label>
            <select name="level" id="" class="form-control">
                <option value="o">O Level</option>
                <option value="a">A Level</option>
            </select>
            <small class="text-danger">{{ $errors->first('level') }}</small>
        </div>

        <div class="col-lg-12 my-3">
            <button type="submit" class="btn btn-primary btn-md rounded-4 w-100">Save</button>
        </div>

       </form>
    </div>
</div>

    
@endsection
