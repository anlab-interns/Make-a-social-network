@extends('profile.profileMaster')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a
                            href="{{url('/profile')}}/{{Auth::user()->name}}">Profile</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a
                            href="{{url('/editProfile')}}/{{Auth::user()->slug}}">Edit profile</a></li>
            </ol>
        </nav>
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">
                    Sidebar
                </div>
            </div>
            <div class="col-md-10">
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
                        <div class="col-sm-12 col-md-12"></div>
                        @foreach($all_users as $ulist)
                            {{--@if(session('status'))--}}
                            {{--@if($data == $ulist->id)--}}
                            {{--@endif--}}
                            <?php
                            $test = DB::table('friends')->where('user_requested', '=', $ulist->id)
                                ->where('requester', '=', Auth::user()->id)
                                ->where('status', '=', 0)->first();
                            if ($test != ''){
                            //                                dd($test)
                            ?>
                            <div class="row " style="border-bottom:1px solid #ccc; margin-bottom:15px">
                                <div class="col-md-2">
                                    @if (($ulist->picture_path == ''))
                                        <img class="row rounded-circle" align="center" style="margin:auto"
                                             src="{{asset('storage/male.png')}}" width="80px" height="80px">
                                    @else
                                        <img class="row rounded-circle" style="margin:auto"
                                             src="../../public/images/{{$ulist->picture_path}}" width="80px"
                                             height="80px">
                                    @endif
                                </div>
                                <div class="col-md-7 float-left">
                                    <p style="margin: 0px"><a
                                                href="{{url('/profile')}}/{{$ulist->name}}">{{ucwords($ulist->name)}}</a>
                                    <p style="margin: 0px">{{$ulist->cty}} - {{$ulist->country}}</p>
                                    <p style="margin: 0px">{{$ulist->about}}</p>
                                    </p>
                                </div>
                                <?php
                                $check = DB::table('friends')
                                    ->where('user_requested', '=', $ulist->id)
                                    ->where('requester', '=', Auth::user()->id)
                                    ->first();
                                ;
                                if($check == ''){
                                ?>

                                <div class="figure-caption" align="center">
                                    <p><a href="{{route('addFriend',[$ulist->id])}}" class="btn btn-info">Add
                                            friend</a></p>

                                </div>
                                <?php } else {?>
                                <p>Request Already Send</p>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            {{--@endif--}}
                        @endforeach
                        <div class="col-sm-12 col-md-12">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
