<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'لوحة التحكم')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body dir="rtl">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div  class="container-fluid">
            <a class="navbar-brand" href="#">لوحة التحكم</a>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
