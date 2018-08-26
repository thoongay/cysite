<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @stack('meta')
    <title>{{$title or '木有标题'}}</title>
    @stack('css')
    <style>
        @stack('css-var')
        @stack('style')
    </style>
</head>
<body>
    @yield('body','木有body')
    @stack('js')
    <script>
        @stack('script')
    </script>
</body>
</html>