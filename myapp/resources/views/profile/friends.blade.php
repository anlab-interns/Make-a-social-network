@extends('profile.profileMaster')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('includes.sidebar')
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Your Friends
                    </div>
                    <div class="card-body">
                        @if (session()->has('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session()->get('msg') }}
                            </div>
                        @endif
                        @foreach($friend as $ulist)
                            <div class="row "
                                 style="border-bottom:1px solid #ccc; margin-bottom:15px; padding-bottom: 10px">
                                <div class="col-md-2">
                                    @if (($ulist->picture_path == ''))
                                        <img class="row rounded-circle" align="center"
                                             style="margin-top: 0px;margin-right: 5px;margin-left: 5px"
                                             src="{{asset('storage/male.png')}}" width="80px" height="80px">
                                    @else
                                        <img class="row rounded-circle" align="center"
                                             style=";margin-left: 20px;margin-right: 5px;margin-top: 5px;"
                                             src="../../public/images/{{$ulist->picture_path}}" width="80px"
                                             height="80px">
                                    @endIf
                                </div>
                                <div class="col-md-7 float-left">

                                    <p style="margin: 0px">
                                        <a href="{{route('profile', $ulist->name)}}">{{ucwords($ulist->name)}}</a>
                                    <p style="margin: 0px"><b>{{$ulist->email}}</b></p>
                                    </p>
                                </div>
                                <div class="figure-caption" align="center">
                                    <p><a href="{{route('removeFriend',[$ulist->requester])}}" class="btn btn-success">Unfriend</a>
                                    </p>

                                </div>
                            </div>
                        @endforeach
                        <div class="col-sm-12 col-md-12">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
