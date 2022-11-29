<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | karigarbazar.com</title>
    <link rel="stylesheet" href="{{ URL::asset('dist/css/adminlte.min.css?v=3.2.0') }}">
    <link rel="stylesheet" href="{{ URL::asset('dist/css/blank_custom.css') }}">
    @yield('page_style')
</head>
<body>
    @yield('content')

    <script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('dist/js/adminlte.min.js?v=3.2.0') }}"></script>
    <script src="{{ URL::asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    @yield('page_javascript')
</body>
</html>








