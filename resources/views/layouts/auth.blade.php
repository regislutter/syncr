<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name') }} - @yield('title')</title>
    {!! HTML::style('css/normalize.min.css') !!}
    {!! HTML::style('css/foundation.min.css') !!}
    <style>
        body {
            background: #F0F0F3;
        }
        .login-box {
            background: #fff;
            border: 1px solid #ddd;
            margin: 100px 0;
            padding: 40px 20px 0 20px;
        }
        a {
            display: block;
            font-size: 14px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="large-3 large-centered columns">
            @yield('content')
        </div>
    </div>
    {!! HTML::script('js/vendor/jquery.js') !!}
    {!! HTML::script('js/foundation.min.js') !!}
</body>
</html>