@php
    $schoolType = tenantSettings('school_type', null, 'schoolviser_setup');
@endphp

@extends(config('delxero.dashboard_layout', 'schoolviser::layouts.main_layout'))

@section('module-page-heading', 'Manage Classes')

@section('module-page-actions')
<x-dropdown 
  buttonLabel="Other Settings" icon="bi-gear"
  :items="[
      [
          'label' => 'Term Translations',
          'url' => route('term.translations.index', 'en'),
          'id' => 'term-translation-link',
          'class' => 'text-primary',
          'data' => ['action' => 'open-term', 'locale' => 'en']
      ],
      [
          'label' => 'Manage Academic Years',
          'url' => route('manageacademicyears.index'),
      ],
      [
          'label' => 'Manage Classes',
          'url' => route('manageclazzs.index'),
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
        'label' => 'Manage '.tenantTrans('schoolviser::terms.label_plural'),
    ]
    
]" />
@endsection
    
@section('content')
<x-alert-errors />
<x-alert-success />

<div class="card">
  <div class="card-body">
    <form action="{{route('manageclazzs.update', ['id' => $clazz->id])}}" method="POST" class="row">
      @csrf

      <div class="col-lg-4">
        <label for="">Class</label>
        <input type="text" class="form-control mb-2" value="{{ old('name') ?? $clazz->name }}" name="name" placeholder="Class Name" />
      </div>

      <div class="col-lg-4">
        <label for="">Abbr</label>
        <input type="text" class="form-control mb-2" value="{{ old('abbr') ?? $clazz->abbr }}" name="abbr" placeholder="Class Short Name" />
      </div>

      <div class="col-lg-4">
        <label for="">Level</label>
        <select name="level" id="" class="form-control">
          <option value="ordinary" {{ ($clazz->level == 'ordinary') ? 'selected' : '' }}>{{ (config('schoolviser.type') == 'primary') ? 'Lower Class' : 'Ordinary' }}</option>
          <option value="advanced" {{ ($clazz->level == 'advanced') ? 'selected' : '' }}>{{ (config('schoolviser.type') == 'primary') ? 'Upper CLass' : 'Advanced' }}</option>
        </select>
      </div>

      <button class="w-100 btn btn-primary btn-sm rounded-5 my-3" type="submit">Update</button>

    </form>
  </div>
</div>

@endsection


