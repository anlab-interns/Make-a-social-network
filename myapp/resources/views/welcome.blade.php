{{--@extends('layouts.master')--}}

{{--@section('title')--}}
    {{--Welcome!--}}
{{--@endsection--}}

{{--@section('content')--}}
    {{--@include('includes.message-block')--}}
    {{--<div class="row">--}}
        {{--<div class="col-md-6">--}}
            {{--<h3>Sign Up</h3>--}}
            {{--<form action=" {{ route('signup') }} " method="post">--}}
                {{--<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">--}}
                    {{--<label for="email">Your E-Mail</label>--}}
                    {{--<input class="form-control" type="text" name="email" id="email" value="{{ Request::old('email') }}">--}}
                {{--</div>--}}
                {{--<div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">--}}
                    {{--<label for="first_name">Your First Name</label>--}}
                    {{--<input class="form-control" type="text" name="first_name" id="first_name" value="{{ Request::old('first_name') }}">--}}
                {{--</div>--}}
                {{--<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">--}}
                    {{--<label for="password">Your Password</label>--}}
                    {{--<input class="form-control" type="password" name="password" id="password" value="{{ Request::old('password') }}">--}}
                {{--</div>--}}
                {{--<button type="submit" class="btn btn-primary">Submit</button>--}}
                {{--<input type="hidden" name="_token" value="{{ Session::token() }}">--}}
            {{--</form>--}}
        {{--</div>--}}
        {{--<div class="col-md-6">--}}
            {{--<h3>Sign In</h3>--}}
            {{--<form action=" {{ route('signin') }} " method="post">--}}
                {{--<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">--}}
                    {{--<label for="email">Your E-Mail</label>--}}
                    {{--<input class="form-control" type="text" name="email" id="email" value="{{ Request::old('email') }}">--}}
                {{--</div>--}}
                {{--<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">--}}
                    {{--<label for="password">Your Password</label>--}}
                    {{--<input class="form-control" type="password" name="password" id="password" value="{{ Request::old('password') }}">--}}
                {{--</div>--}}
                {{--<button type="submit" class="btn btn-primary">Submit</button>--}}
                {{--<input type="hidden" name="_token" value="{{ Session::token() }}">--}}
            {{--</form>--}}
        {{--</div>--}}
{{--@endsection--}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }
        .full-height {
            height: 100vh;
        }
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
        .position-ref {
            position: relative;
        }
        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }
        .content {
            text-align: center;
        }
        .title {
            font-size: 84px;
        }
        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">
            Laravel
        </div>

        <div class="links">
            <a href="https://laravel.com/docs">Docs</a>
            <a href="https://laracasts.com">Laracasts</a>
            <a href="https://laravel-news.com">News</a>
            <a href="https://blog.laravel.com">Blog</a>
            <a href="https://nova.laravel.com">Nova</a>
            <a href="https://forge.laravel.com">Forge</a>
            <a href="https://github.com/laravel/laravel">GitHub</a>
        </div>
    </div>
</div>
</body>
</html>