@extends(config('delxero.dashboard_layout', 'schoolviser::layouts.main_layout'))

@section('title', 'Un registered Students Information')
@section('module-page-heading', 'Un registered Students Information')

@section('hello')
    @php
        $term = term();
    @endphp
    {{ $term->academicYear?->name.' '.$term->name }}
@endsection

@section('module-page-actions')
<a href="{{route('tertiary.students.create')}}" class="btn btn-sm btn-light">Add Student</a>

<div class="btn-group">
    <button
        class="btn btn-secondary dropdown-toggle"
        type="button"
        id="triggerId"
        data-bs-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false"
    >
        Import Registration
    </button>
    <div class="dropdown-menu dropdown-menu-start" aria-labelledby="triggerId">
        <a class="dropdown-item" data-bs-toggle="offcanvas" data-bs-target="#importWithClass">
            Import (Template With Class)
        </a>
        <h6 class="dropdown-header">Advanced Import</h6>
        <a class="dropdown-item" data-bs-toggle="offcanvas" data-bs-target="#importAdvanced">
            Import (Allow Selection Of Class)
        </a>
    </div>
</div>

<!-- Offcanvas: Template With Class -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="importWithClass">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Import Students (Template With Class)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <p>You can download the Excel template and then upload filled student data.</p>
        <a href="{{ route('students.import.downloadTemplate') }}" class="btn btn-outline-primary mb-3">
            Download Template
        </a>

        <form method="POST" action="{{ route('students.import') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Upload Excel File</label>
                <input type="file" name="file" id="file" class="form-control" accept=".xlsx,.csv" required>
            </div>
            <button class="btn btn-success w-100">Import Students</button>
        </form>
    </div>
</div>

<!-- Offcanvas: Advanced Import -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="importAdvanced">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Advanced Import</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <p>Upload Excel and manually select class/stream for all students.</p>
        <a href="" class="btn btn-outline-primary mb-3">
            Download Advanced Template
        </a>

        <form method="POST" action="" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="fileAdvanced" class="form-label">Upload Excel File</label>
                <input type="file" name="file" id="fileAdvanced" class="form-control" accept=".xlsx,.csv" required>
            </div>

            <div class="mb-3">
                <label>Class</label>
                <select name="clazz_id" class="form-control">
                    @foreach ($clazzes as $clazz)
                        <option value="{{ $clazz->id }}">{{ $clazz->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Stream</label>
                <select name="stream_id" class="form-control">
                    
                </select>
            </div>

            <button class="btn btn-success w-100">Import Students</button>
        </form>
    </div>
</div>


@endsection

@section('module-breadcrumbs')
<x-ui.breadcrumb :items="[
    [
        'label' => 'Manage Students',
        'url' => route('students.index')
    ],
    [
        'label' => 'Students Information',
        'url' => route('students.index')
    ],
    [
        'label' => 'Unregisered Students',
        'url' => route('students.index')
    ]
    
]" />
@endsection

@section('content')

@if(session('ignoredDetails') && count(session('ignoredDetails')) > 0)
    <div class="alert alert-warning">
        <strong>Ignored Students:</strong>
        <ul>
            @foreach(session('ignoredDetails') as $row)
                <li>
                    {{ $row['row']['first_name'] ?? 'Unknown' }} {{ $row['row']['last_name'] ?? '' }}
                    — <em>{{ $row['reason'] }}</em>
                </li>
            @endforeach
        </ul>
    </div>
@endif


<x-alert-success />
<x-alert-errors />
<x-alert-warning />

<div class="card">

  <div class="card-header">
    <div class="card-title w-lg-25">
        <form id="searchForm" class="w-100" action="{{ route('students.searchUnregistered') }}" method="GET">
            <input type="text" id="searchInput" name="query" class="form-control" placeholder="Search Students" />
        </form>
    </div>
    <div class="card-toolbar d-none" id="tableItemsChecked">
      <a href="#" id="bulkActionOne" class="btn btn-sm btn-light m-1">Bulk Action One</a>
      <a href="#" class="btn btn-sm btn-light m-1">Bulk Action Two</a>
    </div>
  </div>


  <div class="card-body" id="tableHolder">
    @include('schoolviser::students.partials._unregistered_students_table', ['students' => $students, 'clazzes' => $clazzes])
  </div>

  <div class="card-footer">
      {{ $students->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Toggle bulk action toolbar
    function toggleToolbar() {
        const anyChecked = $('.item-checkbox:checked').length > 0;
        $('#tableItemsChecked').toggleClass('d-none', !anyChecked);
    }

    // Select/Deselect all
    $('#selectAllItems').on('change', function() {
        $('.item-checkbox').prop('checked', $(this).prop('checked'));
        toggleToolbar();
    });

    // Individual checkbox change
    $(document).on('change', '.item-checkbox', function() {
        toggleToolbar();
    });

    $(document).on('change', '#selectAllItems', function() {
        $('.item-checkbox').prop('checked', $(this).prop('checked'));
        toggleToolbar();
    });

    // Also handle individual row checkbox changes
  $(document).on('change', '.item-checkbox', function() {
      // If any row is unchecked, uncheck "select all"
      if (!$(this).prop('checked')) {
          $('#selectAllItems').prop('checked', false);
      } else if ($('.item-checkbox:checked').length === $('.item-checkbox').length) {
          // If all rows are checked, check "select all"
          $('#selectAllItems').prop('checked', true);
      }
      toggleToolbar();
  });


    // Bulk Action One: collect selected IDs
    $('#bulkActionOne').on('click', function(e) {
        e.preventDefault();
        const selectedIds = $('.item-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) return;

        // Example: send via POST
        $.ajax({
            url: "rutehere",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                ids: selectedIds
            },
            success: function(response) {
                alert('Bulk action completed successfully!');
                // Optionally refresh table
                location.reload();
            },
            error: function() {
                alert('Bulk action failed.');
            }
        });
    });

    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        const query = $('#searchInput').val();

        $.ajax({
            url: "{{ route('students.searchUnregistered') }}",
            method: "GET",
            data: { query: query },
            success: function(response) {
                // Replace table body with new results
                $('#tableHolder').html(response.html);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                let message;

                switch (jqXHR.status) {
                    case 403:
                        message = "Access denied (403). You may not have permission.";
                        break;
                    case 404:
                        message = "Resource not found (404). The search endpoint may be incorrect.";
                        break;
                    case 422:
                        // Laravel validation errors usually come back as 422
                        let errors = jqXHR.responseJSON?.errors;
                        if (errors) {
                            let messages = Object.values(errors).flat().join("\n");
                            message = "Validation failed:\n" + messages;
                        } else {
                            message = "Validation error (422).";
                        }
                        break;
                    case 500:
                        message = "Server error (500). Please try again later.";
                        break;
                    default:
                        message = "Request failed (" + jqXHR.status + "): " + errorThrown;
                }

                alert(message);
                console.error("AJAX Error:", {
                    status: jqXHR.status,
                    response: jqXHR.responseText,
                    error: errorThrown
                });
            }
        });
    });


    $('.clazz-select').on('change', function() {
        let streams = $(this).find(':selected').data('streams') || [];
        let targetId = $(this).attr('id').replace('clazz', 'stream'); // Stream target Id
        let $stream = $('#' + targetId).empty();

        $.each(streams, function(_, s) {
            $stream.append(`<option value="${s.id}">${s.name}</option>`);
        });
    });

    // auto-load streams for all default selections
    $('.clazz-select').trigger('change');


});
</script>
@endsection

