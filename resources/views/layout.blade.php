
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->
    <link href="css/layout.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
</head>
@include('layouts.nav')

<body class="text-center">
@yield('content')
@include('layouts.errors')
</body>
</html>
