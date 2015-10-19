<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="{{ $metadata->description }}">
  <meta name="keywords" content="{{ implode(', ', $metadata->keywords) }}">
  <meta name="author" content="{{ $metadata->author }}">

  <title>{{ $metadata->page_title }}</title>

  {{-- <link rel="stylesheet" href="{{'assets/bootstrap/css/bootstrap.min.css'}}"> --}}
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
  <style>
  @section('inline-style')
    footer{
      margin-bottom: 5em;
    }
  @show
  </style>

  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  {{-- <script src="{{ asset('assets/jquery/jquery.min.js') }}"></script> --}}
  {{-- <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script> --}}
</head>
<body>

@yield('content')

<script>
@section('inline-script')
@show
</script>
s
</body>
</html>
