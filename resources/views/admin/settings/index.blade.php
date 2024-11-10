
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
      <div class="card-body">

        <!-- General Settings -->
        <div class="row">
          <div class="col-lg-3 col-sm-12 col-md-3"><h4>General</h4></div>
          <div class="col-md-9 col-lg-9">
            <ul class="list-unstyled">
              <li><a href="{{route('site.settings.school.info')}}" class=" link rounded-1">School Info</a></li>
             
              <li><a href="{{route('settings.terms')}}" class="link rounded-1">{{(config('schoolviser.type','') == 'primary' || config('schoolviser.type','') == 'secondary') ? 'Terms' : 'Intakes'}}</a></li>
              @if (count($modules = config('schoolviser.modules', [])) > 0)
                @foreach ($modules as $module)
                    @includeIf($module.'::includes.settings.general', ['some' => 'data'])
                @endforeach
              @endif
            </ul>
          </div>
          <div class="col-lg-12"><hr /></div>
        </div>

        <!-- Subjects -->
        <div class="row">
          <div class="col-lg-3 col-sm-12 col-md-3"><h4><a href="{{route('site.settings.subjects')}}" class=" link rounded-1">Manage Subjects</a></h4></div>
          <div class=" col-md-9 col-lg-9">
            <ul class="list-unstyled">
              <li><a href="{{route('site.settings.subjects')}}" class=" link rounded-1">Manage Subjects</a></li>
            </ul>
          </div>
          <div class="col-lg-12"><hr /></div>
        </div>

        <!-- User Module Settings -->
        @includeIf('user::includes.settings.main', ['some' => 'data'])


        @if (count($modules = config('schoolviser.modules', [])) > 0)
          @foreach ($modules as $module)
              @includeIf($module.'::includes.settings.main')
          @endforeach
        @else
          <p>Module Settings</p>
        @endif
  
      </div>
    </div>
  </div>







</div>
@endsection
