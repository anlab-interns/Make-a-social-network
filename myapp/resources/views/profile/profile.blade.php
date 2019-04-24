@extends('profile.profileMaster')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('includes.sidebar')
            @foreach($userData as $uData)
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            {{$uData->name}}
                        </div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <div class="img-thumbnail">
                                        <h3 align="center">{{ucwords($uData->name)}}</h3>
                                        @if ((Auth::user()->picture_path == ''))
                                            <img class="row rounded-circle" align="center" style="margin:auto"
                                                 src="{{asset('storage/male.png')}}" width="120px" height="120px">
                                        @else
                                            <img class="row rounded-circle" align="center" style="margin:auto"
                                                 src="../../public/images/{{$uData->picture_path}}" width="120px"
                                                 {{--src="{{Auth::user()->picture_path}}" width="120px"--}}
                                                 height="120px">
                                        @endIf
                                        <div class="figure-caption">
                                            <p align="center">{{$uData->cty}} - {{$uData->country}}</p>
                                            @if ($uData->id == Auth::user()->id)
                                                <p align="center"><a href="{{route('editProfile')}}"
                                                                     class="btn btn-primary"
                                                                     role="button">Edit profile</a></p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-dm-6 col-md-t">
                                    <h4><span class="badge badge-secondary">About</span></h4>
                                    <p>{{$uData->about}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
