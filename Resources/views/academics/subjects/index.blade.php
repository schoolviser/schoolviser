{{-- 
    Schoolviser (https://delgont.co.ug)

    © 2026 Delgont Technologies

    Proprietary License - Unauthorized modification or redistribution prohibited.
    Licensed users may only use this software to host applications and develop modules
    that extend Delxero Engine, subject to a valid license agreement.
--}}

@extends(config('delxero.dashboard_layout', 'schoolviser::layouts.main_layout'))

@section('title', 'Subjects')
@section('module-page-heading', 'Subjects')


@section('module-page-actions')
<a href="here" class="btn btn-sm btn-light">Add Item</a>
@endsection

@section('module-breadcrumbs')
<x-ui.breadcrumb :items="[
    ['label' => 'Academics Settings', 'url' => 'here'],
    ['label' => 'Subjects', 'url' => 'subjects.index'],
]" />
@endsection

@section('content')

<x-alert-success />
<x-alert-errors />
<x-alert-warning />

<div class="card">
  <div class="card-header">
    <div class="card-title w-lg-25">
      <form id="searchForm" class="w-100">
        <input type="text" id="searchInput" class="form-control" placeholder="Search Subjects" />
      </form>
    </div>
    <div class="card-toolbar d-none" id="tableItemsChecked">
      <a href="#" id="bulkActionOne" class="btn btn-sm btn-light m-1">Bulk Action One</a>
      <a href="#" class="btn btn-sm btn-light m-1">Bulk Action Two</a>
    </div>
  </div>

  <div class="card-body">
    @include('schoolviser::academics.subjects.partials._subjects_table', ['subjects' => $subjects])
  </div>

  <div class="card-footer">
      {{ $subjects->links() }}
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

    // Bulk Action One: collect selected IDs
    $('#bulkActionOne').on('click', function(e) {
        e.preventDefault();
        const selectedIds = $('.item-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) return;

        $.ajax({
            url: "jj", // replace with actual route
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                ids: selectedIds
            },
            success: function(response) {
                alert('Bulk action completed successfully!');
                location.reload();
            },
            error: function() {
                alert('Bulk action failed.');
            }
        });
    });

    // Search logic
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        const query = $('#searchInput').val();

        $.ajax({
            url: "", // replace with actual route
            method: "GET",
            data: { q: query },
            success: function(response) {
                $('tbody').html(response.html);
            },
            error: function() {
                alert('Search failed.');
            }
        });
    });
});
</script>
@endsection
