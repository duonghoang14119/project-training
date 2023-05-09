<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/product.css') }}">
</head>
<body>
@include('header')

<div class="home">
    @include('filter')
    <div class="content">
        <div class="above-content">
            @include('search')
        </div>
        <div class="homepage-content">
            <div class="homepage-content-item">
                <p>{{ config('my_config.wellCome') }}</p>
            </div>

        </div>

    </div>

</div>
</body>
</html>
