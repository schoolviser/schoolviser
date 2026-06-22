@php
    $schoolType = dx_config('schoolviser_school_type_'.company()->uuid, null);
    $intakes = config('schoolviser.intakes');

    $termName = ($schoolType == 'primary' || $schoolType == 'secondary') ? 'Terms' : 'Intakes';
@endphp

@extends(config('delxero.dashboard_layout', 'schoolviser::layouts.main_layout'))


@section('module-page-heading', tenantTrans('schoolviser::terms.label_plural'))

@section('module-page-actions')
<a href="" data-bs-toggle="offcanvas" data-bs-target="#addIntake" class="btn btn-sm btn-light">Add {{tenantTrans('schoolviser::terms.label')}}</a>
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

<div class="row mt-3">
  
  @if (count($terms))
  <div class="col-lg-12">
    <div class="row">
      <div class="col-12">

        <div class="card">
          <div class="table-responsive card-body">
            <table class="table table-hover align-middle table-row-dashed fs-6 gy-5">

              <thead class="">
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                  <th class="">SN</th>
                  <th>Year</th>
                  <th>{{ tenantTrans('schoolviser::terms.label_plural') }}</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Next {{ tenantTrans('schoolviser::terms.label') }}</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>

              <tbody class="text-gray-600 fw-semibold">
                  @foreach ($terms as $term)
                    @if (term()?->term == $term->term && term()->year_id == $term->year_id)
                    <tr class="px-3">
                      <td>{{ $loop->index + 1 }}</td>
                      <td><small class="text-capitalize">{{ $term->academicYear?->name }}</small></td>
                      <td><small class="text-capitalize">{{ $intakes[$term->term] }}</small></td>
                      <td><small class="text-capitalize">{{ $term->start_date }}</small></td>
                      <td><small class="text-capitalize">{{ $term->end_date }}</small></td>
                      <td><small class="text-capitalize">{{ $term->next_term_start_date }}</small></td>
                      <td>
                        <a href="{{route('manageterms.edit', ['id' => $term->uuid])}}" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i></a>
                        <a href="{{route('manageterms.delete', ['id' => $term->uuid])}}" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                      </td>
        
                    </tr>
                    @else
                    <tr class="">
                      <td>{{ $loop->index + 1 }}</td>
                      <td><small class="text-capitalize">{{ $term->academicYear?->name }}</small></td>
                      <td><small class="text-capitalize ">{{ $intakes[$term->term] }}</small></td>
                      <td><small class="text-capitalize">{{ $term->start_date }}</small></td>
                      <td><small class="text-capitalize">{{ $term->end_date }}</small></td>
                      <td><small class="text-capitalize">{{ $term->next_term_start_date }}</small></td>
                      <td></td>
                    </tr>
                    @endif
                  
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-12 my-2">
      </div>
    </div>
  </div>


  @else

  @endif

  <div class="col-lg-6">
  </div>
</div>


<div
  class="offcanvas offcanvas-start"
  data-bs-scroll="true"
  tabindex="-1"
  id="addIntake"
  aria-labelledby="Enable both scrolling & backdrop"
>
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="Enable both scrolling & backdrop">
      Add New Intake
    </h5>
    <button
      type="button"
      class="btn-close"
      data-bs-dismiss="offcanvas"
      aria-label="Close"
    ></button>
  </div>
  <div class="offcanvas-body">
    <form class="card-body row" action="{{ route('manageterms.store') }}" method="POST">
      @csrf

      <div class="col-lg-12">
        errors here
      </div>

      <div class="col-lg-6">
        <label for="" class="font-10 text-muted">Year</label>
        <select name="year_id" id="" class="form-control">
          @foreach ($years as $year)
          <option value="{{ $year->id }}">{{ $year->name }}</option>
          @endforeach
        </select>
        <small class="text-danger error-year-id">{{ $errors->first('year_id') }}</small>

      </div>

      <div class="col-lg-6">
        <label for="" class="font-10 text-muted">Term</label>
        <select name="term" class="form-control text-danger rounded-0">
          <option value="1" selected>{{ tenantTrans('schoolviser::terms.one') }}</option>
          <option value="2">{{ tenantTrans('schoolviser::terms.two') }}</option>
          <option value="3">{{ tenantTrans('three') }}</option>
        </select>
        <small class="text-danger error-term">{{ $errors->first('term') }}</small>

      </div>

      <div class="col-lg-6">
        <label for="" class="font-10 text-muted">Start Date</label>
        <input type="date" class="form-control" name="start_date" value="{{old('start_date')}}" />
        <small class="text-danger error-start-date">{{ $errors->first('start_date') }}</small>
      </div>

      <div class="col-lg-6">
        <label for="" class="font-10 text-muted">Start Date</label>
        <input type="date" class="form-control" name="end_date" value="{{old('end_date')}}" />
        <small class="text-danger error-end-date">{{ $errors->first('end_date') }}</small>
      </div>

      <div class="col-lg-12">
        <label for="" class="font-10 text-muted">Next Term Start Date</label>
        <input type="date" class="form-control" name="next_term_start_date" value="{{old('next_term_start_date')}}" />
        <small class="text-danger error-next-term-start-date">{{ $errors->first('next_term_start_date') }}</small>
      </div>
      <div class="col-lg-12 py-3">
        <small class="text-danger error-date-range"></small>
      </div>

      <div class="col-lg-12 my-2">
        <button type="submit" class="btn btn-primary btn-md rounded-5 w-100">Save Term</button>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
$(function() {
    $('form[action="{{ route('manageterms.store') }}"]').on('submit', function(e) {
        e.preventDefault();

        let $form = $(this);
        let $submitBtn = $form.find('button[type="submit"]');
        let formData = $form.serialize();

        // Clear old errors
        $form.find('.text-danger').text('');

        $submitBtn.prop('disabled', true).text('Saving...');

        $.ajax({
            url: $form.attr('action'),
            method: $form.attr('method'),
            data: formData,
            dataType: 'json'
        })
        .done(function(response) {
            alert(response.message);

            //let selectedTerm = $form.find('[name="term"]').val();
            //$form[0].reset();
            //$form.find('[name="term"]').val(selectedTerm);
        })
        .fail(function(xhr, status, error) {
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                // Validation errors
                let errors = xhr.responseJSON.errors;

                // Clear all error placeholders first
                $form.find('.text-danger').text('');

                $.each(errors, function(field, messages) {
                    // one-liner: map field name to .error-{field} class
                    $form.find('.error-' + field.replace(/_/g, '-')).text(messages[0]);
                });

            } else {
                // Other errors (500, 404, network, etc.)
                let message = "Unexpected error (" + xhr.status + "): " + error;
                if (xhr.responseText) {
                    message += "\n\n" + xhr.responseText;
                }
                alert(message);
            }
        })
        .always(function() {
            $submitBtn.prop('disabled', false).text('Save Term');
        });
    });
});
</script>
@endsection
