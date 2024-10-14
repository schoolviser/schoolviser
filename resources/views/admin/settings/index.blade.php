
@extends(config('schoolviser.admin_layout'))

@section('module-page-heading', 'Settings')

@section('pageheaderDescription', 'A place to configure all your system configurations.')

@section('where-am-i')
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('settings')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1">Settings</a>
@endsection

@section('module-links')
    
@endsection
    

@section('content')
<div class="row row-1">

  <div class="col-lg-12">
    <div class="card">
      <div class="card-body row">

        <div class="col-lg-4">
          <h4 class="mb-0 p-0">General</h4>
          <div class="list-unstyled">
            <li><a href="{{route('site.settings.school.info')}}" class=" link rounded-1">School Info</a></li>
            <li><a href="{{route('settings.terms')}}" class="link rounded-1">{{(config('schoolviser.type','') == 'primary' || config('schoolviser.type','') == 'secondary') ? 'Terms' : 'Intakes'}}</a></li>
            <li><a href="{{route('settings.year.groups')}}" class="link rounded-1">Year Groups</a></li>
            @if (count($modules = config('schoolviser.modules', [])) > 0)
              @foreach ($modules as $module)
                  @includeIf($module.'::includes.settings.general', ['some' => 'data'])
              @endforeach
            @endif
          </div>
        </div>

        @if (count($modules = config('schoolviser.modules', [])) > 0)
          @foreach ($modules as $module)
              @includeIf($module.'::includes.settings.main', ['some' => 'data'])
          @endforeach
        @else
          hello
        @endif

      </div>
    </div>
  </div>


</div>
@endsection
