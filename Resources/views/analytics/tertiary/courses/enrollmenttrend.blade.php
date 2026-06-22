@extends(config('delxero.layouts.dashboard.layout', 'layouts.dashboard.light_header_layout'))

@section('title', 'Course Enrollment Trend')
@section('module-page-heading', 'Course Enrollment Trend')

@section('module-breadcrumbs')
<x-ui.breadcrumb :items="[
    [
        'label' => 'Analytics',
    ],
    [
        'label' => 'Course',
    ],
    [
        'label' => 'Course Enrollment Trend',
    ]
    
]" />
@endsection

@section('requiredJs')
    {{-- Include Chart.js from CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- Your module-specific JS if needed --}}
    <script src="{{ asset('modules/schoolviser/js/tertiary_students.js') }}" defer></script>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Enrollment Trend</h2>
            </div>
            <div class="card-body">
                <canvas id="enrollmentTrendChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Chart data passed from controller
    const chartData = @json($chartData);

    const ctx = document.getElementById('enrollmentTrendChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Course Enrollment Trends'
                }
            },
            scales: {
                x: {
                    title: { display: true, text: 'Intakes' }
                },
                y: {
                    title: { display: true, text: 'Enrollments' },
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
