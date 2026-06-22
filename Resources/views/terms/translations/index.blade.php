@extends(config('delxero.dashboard_layout', 'schoolviser::layouts.main_layout'))

@section('module-page-heading', 'Term Translations '.$locale)

@section('module-page-actions')
<x-dropdown 
  buttonLabel="Other Settings" icon="bi-gear"
  :items="[
      [
          'label' => 'Manage '.tenantTrans('schoolviser::terms.label_plural'),
          'url' => route('manageterms.index'),
      ],
      [
          'label' => 'Manage Academic Years',
          'url' => route('manageacademicyears.index'),
      ]
  ]"
/>
@endsection

@section('module-breadcrumbs')
<x-ui.breadcrumb :items="[
    [
        'label' => 'Settings',
    ],
    [
        'label' => 'Term Translations',
    ]
    
]" />
@endsection

@section('content')
<div class="card">
    <form action="{{ route('term.translations.index', $locale) }}" method="POST" class="card-body">
        @csrf

        <div class="form-group mb-2">
            <label>Term One</label>
            <input type="text" name="translations[schoolviser::terms.one]" 
                   value="{{ $translations['schoolviser::terms.one'] ?? __('schoolviser::terms.one') }}" 
                   class="form-control">
        </div>

        <div class="form-group mb-2">
            <label>Term Two</label>
            <input type="text" name="translations[schoolviser::terms.two]" 
                   value="{{ $translations['schoolviser::terms.two'] ?? __('schoolviser::terms.two') }}" 
                   class="form-control">
        </div>

        <div class="form-group mb-2">
            <label>Term Three</label>
            <input type="text" name="translations[schoolviser::terms.three]" 
                   value="{{ $translations['schoolviser::terms.three'] ?? __('schoolviser::terms.three') }}" 
                   class="form-control">
        </div>

        <div class="form-group mb-2">
            <label>Singular Label</label>
            <input type="text" name="translations[schoolviser::terms.label]" 
                   value="{{ $translations['schoolviser::terms.label'] ?? __('schoolviser::terms.label') }}" 
                   class="form-control">
        </div>

        <div class="form-group mb-2">
            <label>Plural Label</label>
            <input type="text" name="translations[schoolviser::terms.label_plural]" 
                   value="{{ $translations['schoolviser::terms.label_plural'] ?? __('schoolviser::terms.label_plural') }}" 
                   class="form-control">
        </div>

        <button type="submit" class="btn btn-primary btn-sm mt-3 w-100">Save Translations</button>
    </form>
</div>
@endsection