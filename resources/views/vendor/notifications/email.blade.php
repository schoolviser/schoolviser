<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        h1 { color: #333; }
        .button {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .button:visited { color: #fff; }
        .footer { font-size: 12px; color: #888; }
    </style>
</head>
<body>

    <!-- Greeting -->
    <h1>{{ !empty($greeting) ? $greeting : ($level === 'error' ? 'Whoops!' : 'Hello!') }}</h1>

    <!-- Intro Lines -->
    @foreach ($introLines as $line)
        <p>{{ $line }}</p>
    @endforeach

    <!-- Action Button -->
    @isset($actionText)
        <p>
            <a href="{{ $actionUrl }}" class="button" style="background-color: 
            @if($level === 'success') #28a745; 
            @elseif($level === 'error') #dc3545; 
            @else #007bff; 
            @endif">
                {{ $actionText }}
            </a>
        </p>
    @endisset

    <!-- Outro Lines -->
    @foreach ($outroLines as $line)
        <p>{{ $line }}</p>
    @endforeach

    <!-- Salutation -->
    <p>{{ !empty($salutation) ? $salutation : 'Regards,' }}<br>{{ config('app.name') }}</p>

    <!-- Subcopy -->
    @isset($actionText)
        <p class="footer">
            If you're having trouble clicking the "{{ $actionText }}" button, copy and paste the URL below into your web browser: <br>
            <a href="{{ $actionUrl }}">{{ $actionUrl }}</a>
        </p>
    @endisset

</body>
</html>
