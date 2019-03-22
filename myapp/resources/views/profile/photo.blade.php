@extends('profile.profileMaster')
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/profile')}}/{{Auth::user()->slug}}">Profile</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/editProfile')}}/{{Auth::user()->slug}}">Edit
                        profile</a></li>
                <li class="breadcrumb-item active"><a href="">Change image</a></li>
            </ol>
        </nav>
        <div class="row justify-content-center">
            @include('includes.sidebar')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        {{Auth::user()->name}}
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="col-sm-12 col-md-12">
                            <div class="img-thumbnail">
                                <h3 align="center">{{ucwords(Auth::user()->name)}}</h3>
                                @if ((Auth::user()->picture_path == ''))
                                    <img class="row rounded-circle" align="center" style="margin:auto"
                                         src="{{asset('storage/male.png')}}" width="120px" height="120px">
                                @else
                                    <img class="row rounded-circle" align="center" style="margin:auto"
                                         src="../../public/images/{{Auth::user()->picture_path}}" width="120px"
                                         {{--src="{{Auth::user()->picture_path}}" width="120px"--}}
                                         height="120px">
                                @endIf
                                <div class="figure-caption">
                                    <p align="center">{{$data->cty}}-{{$data->country}}</p>
                                </div>
                            </div>

                        </div>
                        <form class="col-sm-12 col-md-12" style="margin-top: 10px" action="{{route('updatePhoto')}}"
                              method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="file" name="pic" class="form-control-file" id="exampleFormControlFile1">
                            <input type="submit" name="btn" class="btn-success" style="margin-top: 10px;">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
