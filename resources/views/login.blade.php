<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<style>
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        /*background-image: url('path/to/image.jpg');*/
        background-size: cover;
        background-position: center;
    }

    .container {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    .form-login {
        text-align: center;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        width: 300px;
    }
    #email {
        width: 84%;
        padding: 15px 10px 15px;
        font-size: 14px;
        background: transparent;
        border: 2px solid #537b35;
        outline: none;
        margin-bottom: 26px;
    }
    #password {
        width: 84%;
        padding: 15px 10px 15px;
        font-size: 14px;
        background: transparent;
        border: 2px solid #537b35;
        outline: none;
        margin-bottom: 26px;
    }
    .submit {
        font-size: 16px;
        padding: 10px 65px;
        background-color: #537b35;
        color: #FFF;
        border: none;
        border-radius: 0px;
        outline: none;
        float: none;
        cursor: pointer;
    }

    .error-message {
        color: red;
    }

</style>
<div class="container">
    <div class="form-login center">
        <h2>Login here</h2>
        <form method="POST" action="/admin/login">
            @csrf

            @error('email')
            <span class="error-message">{{ $message }}</span>
            @enderror
            <input type="email" name="email" placeholder="EMAIL" id="email" ><br>

            @error('password')
            <span class="error-message">{{ $message }}</span>
            @enderror
            <input type="password" name="password" placeholder="PASSWORD" id="password" ><br>

            <button type="submit" class="submit">Login</button>
        </form>
        <p> To register new account <span>→</span> <a class="w3_play_icon1" href="{{ route('register') }}">Click Here</a></p>
    </div>
</div>


</body>
</html>
