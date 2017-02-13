<html>
<head>
    <title>{{ $header_info['title'] }}</title>
    <meta name="description" content="{{ $header_info['subject'] }}">
    <meta name="keywords" content="{{ $header_info['keywords'] }}">
    <meta name="author" content="{{ $header_info['author'] }}">
    <style>
        body {
            font-family: {{ $font['family'] }};
            font-size: {{ $font['size'] }}pt;
            margin: {{ $margins['top'] }} {{ $margins['right'] }} {{ $margins['bottom'] }} {{ $margins['left'] }};
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
