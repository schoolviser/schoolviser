<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-12 text-uppercase">
                <small class="mb-0 p-0 fw-bold">{{ 'General Settings' }}</small>
            </div>
        </div>
    </div>
    <div class="card-body">
      <ul class="list-unstyled">
        @usertype('master')<li><a href="{{route('site.settings.school.info')}}" class=" link rounded-1">School Info</a></li>@endusertype
        <li><a href="{{route('settings.terms')}}" class="link rounded-1">{{(config('schoolviser.type','') == 'primary' || config('schoolviser.type','') == 'secondary') ? 'Terms' : 'Intakes'}}</a></li>
        
        @rolecan('can_manage_subjects')<li><a href="{{route('site.settings.subjects')}}" class=" link rounded-1">Manage Subjects</a></li>@endrolecan
        
        @if (count($modules = config('schoolviser.modules', [])) > 0)
          @foreach ($modules as $module)
              @includeIf($module.'::includes.settings.general', ['some' => 'data'])
          @endforeach
        @endif
      </ul>
    </div>
  </div>