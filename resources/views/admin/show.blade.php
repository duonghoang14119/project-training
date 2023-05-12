<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">

    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}">

</head>
<body>
@include('header')
<div class="home">
    @include('filter')
    <div class="content" style="height: auto">
        <div class="detail-product-page">
            <div class="btn-back">
                <a href="{{ route('products.index') }}">
                    <img src="{{ asset('images/back.png') }}" alt="">
                    <span>{{ config('my_config.back') }}</span>
                </a>
            </div>
            <br>

            <div class="product-information">
                <div class="left-information">
                    <h3>{{$data->name}}</h3>
                    <p class="product-test">{{ config('my_config.category') }}: {{$data->category->name}}</p><br>
                    <p class="product-test">{{ config('my_config.manufacturer') }}: {{$data->manufacturer->name}}</p><br>
                    <p class="product-test">{{ config('my_config.price') }}: $ {{ $data->price }}</p><br>
                    <p class="product-test">{{ config('my_config.outline') }}:<br> {{ $data->description }} </p>
                </div>
                <div class="right-information slider">
                    <div>
                        <img style="width: 100%; height: 100%" src="{{ asset('images/'. $data->image_path) }}" alt="" class="img-product">
                    </div>
                        @foreach ($data->images as $image)
                            <div>
                                <img style="width: 100%; height: 100%" src="{{ asset('images/'. $image->path) }}" alt="" class="img-product">
                            </div>
                        @endforeach

{{--                    <img style="width: 100%; height: 100%" src="{{ asset('images/'. $data->image_path) }}" alt="" class="img-product"><br>--}}
                </div>
            </div>

            @if(!$recommendedProducts->isEmpty())
                <div class="suggest-product">
                    <p>Suggestions For You:</p>
                    <div class="suggest-product" style="display: flex">
                        @foreach($recommendedProducts as $item)
                            <div class="detail-content">
                                <div class="detail-product">
                                    <img src="{{ asset('images/'. $item->image_path) }}" alt="" class="img-product"
                                         style="padding: 16px; width: 230px; height: 130px"><br>

                                    <div class="name-price" style="padding: 10px 10px 10px 20px;">
                                        <a href="{{ route('products.show',$item->id) }}">{{ $item->name }}</a><br>
                                        <span style="color: #565656">$ {{ $item->price }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
            </div>
            @endif
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/slick.min.js') }}"></script>
<script>
    // $('.slider').slick({
    //     dots: true,
    $(document).ready(function(){
        $('.slider').slick({
            dots: true,
            autoplay: true,
            autoplaySpeed: 5000,
            infinite: true,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1
        });
    });
</script>
</body>
</html>
