@extends(config('schoolviser.admin_layout'))

@section('content')
<div class="container">
    <h1>System Configuration Snapshot</h1>
    <table class="table table-bordered">
        @foreach($config as $key => $value)
            <tr>
                <td><strong>{{ $key }}</strong></td>
                <td>
                    @if(is_array($value))
                        <pre>{{ print_r($value, true) }}</pre>
                    @else
                        {{ $value }}
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</div>
@endsection