<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >
    </head>
    <body>
        <div class="container">
          @yield('content')
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript">
      $.ajaxSetup({
         headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
      });
    </script>
    <script type="text/javascript" src="{{ asset('js/welcome.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/facebook.js') }}"></script>
</html>