@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a
                            href="{{url('/profile')}}/{{Auth::user()->name}}">Profile</a></li>
            </ol>
        </nav>
        <div class="row justify-content-center">
            @include('includes.sidebar')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        You are logged in!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
