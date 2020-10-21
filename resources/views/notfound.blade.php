<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Full Stack Blog</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script>
        (function () {
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            };
        })();
    </script>

</head>
<body>
<div id="app" style="display:flex;height: 80%">
    <div style="margin:auto;margin-top:270px;text-align: center">
        <p><i class="fa fa-frown-o fa-5x" aria-hidden="true"></i></p><br>
        <p><h1>403</h1></p><br>
        <p><h4>Forbidden or No Permission to Access</h4></p>
    </div>
</div>
</body>
<script src="{{mix('/js/app.js')}}"></script>
</html>
