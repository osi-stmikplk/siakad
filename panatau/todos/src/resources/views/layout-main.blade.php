<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Panatau TODOS</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset("$panatauPublicPath/bootstrap.min.css") }}">
    @yield('scriptjs-head')
</head>
<body>
    @yield('content')
    <script src="{{ asset($panatauPublicPath.'/vue.min.js') }}"></script>
    @yield('scriptjs-bottom')
</body>
</html>