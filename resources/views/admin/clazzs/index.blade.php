@extends(config('schoolviser.admin_layout'))

@section('title', 'Home')

@section('module-page-heading', 'Class')
@section('pageheaderDescription', 'Manage your classes')

@section('module-links')

@endsection

@section('requiredJs')

@endsection
    
@section('content')

<div class="row row-1">
  <div class="col-lg-12">
    @include('admin.includes.alerts.created')
    @include('admin.includes.alerts.deleted')
    @include('admin.includes.alerts.updated')
  </div>
  <div class="col-lg-9">
    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped" id="studentsTables">
        <thead>
          <tr>
            <th></th>
            <th>Class</th>
            <th>Level</th>
            <th>Section</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($clazzs as $clazz)
                <tr>
                  <td>{{ $loop->index + 1 }}</td>
                  <td>{{ $clazz->name }}</td>
                  <td>{{ $clazz->level }}</td>
                  <td>
                    @if ($clazz->termly_registrations_count <= 0)
                        <a href="{{route('settings.clazzs.destroy', ['id' => $clazz->id])}}" class="btn btn-danger btn-sm"><i class="mdi mdi-delete fa fa-trash"></i></a>
                    @endif
                    <a href="{{ route('settings.clazzs.edit', ['id' => $clazz->id]) }}" class="btn btn-primary btn-sm"><i class="mdi mdi-edit fa fa-edit"></i></a>
                  </td>
                </tr>
                
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-lg-3">
    <form action="{{ route('settings.clazzs.store') }}" method="POST">
      @csrf
      <input type="text" class="form-control mb-2" name="name" placeholder="Class Name" />
      <input type="text" class="form-control mb-2" name="abbr" placeholder="Class Short Name" />

      <select name="level" id="" class="my-2 form-control">
        <option value="ordinary" selected>{{ (config('schoolviser.type') == 'primary') ? 'Lower CLass' : 'Ordinary' }}</option>
        <option value="advanced">{{ (config('schoolviser.type') == 'primary') ? 'Upper CLass' : 'Advanced' }}</option>
      </select>

      <input type="submit" value="Add" class="btn btn-primary btn-sm rounded-4 w-100" />
    </form>
  </div>
</div>

@endsection
