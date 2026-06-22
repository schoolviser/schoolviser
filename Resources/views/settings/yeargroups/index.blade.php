@extends(config('student.layout', 'student::layouts.master'))


@section('module-page-heading', 'Configure Year Groups')
@section('pageheaderDescription', 'Manage Students')

@section('module-links')
<a href="{{ route('settings.year.groups.create') }}">Create New</a>
<a href="{{ route('settings') }}">Settings</a>
@endsection

@section('where-am-i')

@endsection

@section('content')

<div class="row">

  <div class="col-lg-4">
    <div
      class="table-responsive"
    >
      <table
        class="table table-hover table-striped table-bordered"
      >
        <thead>
         <th>Group Name</th>
         <th>Students</th>
        </thead>
        <tbody>
          @foreach ($yearGroups as $group)
              <tr>
                <td>{{ $group->name }}</td>
                <td>{{ $group->students_count }}</td>
                <td>
                  <a href="{{ route('settings.year.groups.edit', ['id' => $group->id]) }}">Edit</a>
                </td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    
  </div>

  

</div>


@endsection
