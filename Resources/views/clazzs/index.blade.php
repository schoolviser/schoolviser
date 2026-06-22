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
<x-alert-success />
<x-alert-errors />

<div class="row row-1">
  <div class="col-lg-9">
    <div class="card">
      <div class="card-body">
        <table class="table table-hover align-middle table-row-dashed fs-6 gy-5" id="classesTable">
          <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
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
                          <a href="{{route('manageclazzs.destroy', ['id' => $clazz->id])}}" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                      @endif
                      <a href="{{ route('manageclazzs.edit', ['id' => $clazz->id]) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i></a>
                    </td>
                  </tr>
                  
              @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-3">
    <div class="card">
      <div class="card-body">
        <form action="{{ route('manageclazzs.store') }}" method="POST" id="classForm" class="">
          @csrf
          <input type="text" class="form-control mb-2" name="name" placeholder="Class Name" />
          <input type="text" class="form-control mb-2" name="abbr" placeholder="Class Short Name" />

          <select name="level" id="" class="my-2 form-control">
            <option value="ordinary" selected>{{ ($schoolType == 'primary') ? 'Lower CLass' : 'Ordinary' }}</option>
            <option value="advanced">{{ ($schoolType == 'primary') ? 'Upper CLass' : 'Advanced' }}</option>
          </select>

          <input type="submit" value="Add" class="btn btn-primary btn-sm rounded-4 w-100" />
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
@section('script')
<script>
document.addEventListener("DOMContentLoaded", function() {

    $('#classForm').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let data = form.serialize();

        // Clear previous errors
        $('.error').remove();

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Append new class to table
                    $('#classesTable tbody').append(`
                        <tr>
                            <td>${response.clazz.id}</td>
                            <td>${response.clazz.name}</td>
                            <td>${response.clazz.abbr}</td>
                            <td>${response.clazz.level}</td>
                        </tr>
                    `);

                    // Reset form
                    form[0].reset();

                    // Show success message
                    alert(response.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        let input = $('[name="'+key+'"]');
                        input.after('<span class="error text-danger">'+value[0]+'</span>');
                    });
                } else {
                    alert('Something went wrong. Please try again.');
                }
            }
        });
    });
    
});
</script>
@endsection