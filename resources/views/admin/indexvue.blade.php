<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vue Application</title>
    <!-- Include your CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div id="app">
        <!-- Vue will mount here -->
        <!-- Use the Vue component -->
        <term-index></term-index>
    </div>

    <!-- Include your JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
