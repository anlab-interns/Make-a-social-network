@extends('profile.profileMaster')
@section('content')
    <div class="container">
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
                                    <p align="center"><a href="{{route('changePhoto')}}" class="btn btn-primary"
                                                         role="button">Change image</a></p>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-12 col-md-12">
                            <span class="badge badge-secondary">Update your profile</span>
                            <br>
                            <form action="{{route('updateProfile')}}" method="post">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="row">
                                    <div class="col-md-6">

                                        <span id="basic-addon1">City name</span>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="City Name" name="cty">
                                        </div>
                                        <br>
                                        <span id="basic-addon1">Country name</span>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Country Name"
                                                   name="country">
                                        </div>
                                        <br>

                                    </div>
                                    <div class="col-md-6">
                                        <span id="basic-addon1">About</span>
                                        <div class="input-group">
                                            <textarea type="text" class="form-control"
                                                      name="about"></textarea>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <input type="submit" class="btn btn-success float-right">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
