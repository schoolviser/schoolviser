
@extends(config('schoolviser.admin_layout'))

@section('module-page-heading', 'Settings')

@section('module-page-description', config('schoolviser.school_name'))
@section('module-page-description-right', 'A place to configure all your system configurations.')


@section('where-am-i')
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('settings')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1">Settings</a>
@endsection

@section('module-links')
    
@endsection
    

@section('content')
<div class="row row-1">

  <!-- GENERAL SETTINGS -->
  <div class="col-lg-4">
    @include('admin.includes.settings.general')
  </div>

  <!-- User Module Settings -->
  @includeIf('user::includes.settings.main', ['some' => 'data'])

  <!-- Admission Module Setttings -->

  @includeIf('admission::includes.settings.main', ['some' => 'data'])


  @if (count($modules = config('schoolviser.modules', [])) > 0)
    @foreach ($modules as $module)
        @includeIf($module.'::includes.settings.main')
    @endforeach
  @else
    <p>Module Settings</p>
  @endif

</div>
@endsection
