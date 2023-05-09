<head>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>

<header class="header">
    <div class="header-header">
        <div class="logo">
            <img class="image5" src="{{ asset('images/image 5.png') }}">
            <p class="test">NCC</p>
        </div>
        @if(Auth::check())
            <a class="logout-button" href="{{ route('logout') }}">Logout</a>
        @else
            <a class="logout-button" href="{{ route('login') }}" style="background-color: #0b0b0b">Login</a>
        @endif
        @if(isset($user))
            <p>Hello {{$user->name}}</p>
        @endif
    </div>
</header>
