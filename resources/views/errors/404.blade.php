<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 | Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-center d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div>
        <h1 class="display-1 text-danger">404</h1>
        <p class="lead">Sorry, the page you’re looking for doesn’t exist.</p>

        @php
            $frontendMode = config('app.frontend');
            $homeUrl = $frontendMode === 'vue' ? route('app') : url('/');
        @endphp

        <a href="{{ $homeUrl }}" class="btn btn-primary mt-3">Go Home</a>
    </div>
</body>
</html>
