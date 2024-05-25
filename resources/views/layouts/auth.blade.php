<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @yield('title')
    </title>   
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://kit.fontawesome.com/ad2db55012.js" crossorigin="anonymous"></script>
   
</head>

<body>
   @yield('content')
    
   <footer>
    <div class="container my-3 text-center">
        <p>&copy; <?php echo date('Y'); ?> Your Company Name. All rights reserved.</p>
    </div>
</footer>
</body>

</html>
