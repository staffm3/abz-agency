<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ABZ | Test Assignment</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/core.css') }}">
    <link rel="icon" href="{{ asset('img/favicon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon.svg') }}">
    <link rel="apple-touch-startup-image" href="{{ asset('img/favicon.svg') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>
<body>
<x-navbar />
{{ $slot }}
<script src="{{ asset('js/api.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>
