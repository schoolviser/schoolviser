@extends(env('ADMIN_LAYOUT'))


@section('module-page-heading', 'Dashboard')

@section('module-page-description', config('schoolviser.school_name'))
@section('module-page-description-right', config('schoolviser.school_name'))

@section('module-links')
    <a href="" class="module-link btn btn-primary rounded-5 btn-sm"  data-bs-target="#newGroup"  data-bs-toggle="offcanvas">New Group</a>
    <div
        class="offcanvas offcanvas-start"
        data-bs-scroll="true"
        tabindex="-1"
        id="newGroup"
        aria-labelledby="Enable both scrolling & backdrop"
    >
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="Enable both scrolling & backdrop">
                Add New Course Group
            </h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas"
                aria-label="Close"
            ></button>
        </div>
        <div class="offcanvas-body">
            <p>
                Try scrolling the rest of the page to see this option in
                action.
            </p>
        </div>
    </div>

@endsection



@section('requiredCss')
<style>
  .table-responsive {
    overflow-x: auto !important;
  }


</style>
@endsection

@section('requiredJs')
<script src="{{ asset('chart.js/Chart.min.js') }}" defer></script>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
             <div class="card-header">
                <div class="row">
                    <div class="col-lg-12 text-uppercase">
                        <small class="mb-0 p-0 fw-bold">{{ 'Course Groups' }}</small>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div
                    class="table-responsive m-0"
                >
                    <table
                        class="table table-hover table-striped m-0"
                    >
                        <thead>
                            <th>ID</th>
                            <th>Group Name</th>
                            <th>Course</th>
                        </thead>
                        <tbody>
                            @foreach ($courseGroups as $group)
                            <tr>
                                <td>{{ $group->id }}</td>
                                <td>{{ $group->name }}</td>
                                <td>{{ $group->course->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-footer">
                {{ $courseGroups->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
