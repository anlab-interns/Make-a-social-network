{{--Kế thừa giao diện file app.blade.php--}}
@extends('layouts.app')

@section('title')
    My Dashboard
@endsection


@section('content')
    {{--@include('includes.message-block')--}}
    <div class="container" style="justify-content: center; align-content: center;margin: auto">
        <section class="row new-post">
            <div class="card" style="margin: auto;border-width: 1px;border-color: gray;width: 60%">
                <div class="card-header">What do you think?</div>
                <div>
                    <form action="{{ route('post.create') }}" method="post">
                        <div class="form-group" style="display: flex;flex-direction: row">
                            @if ((Auth::user()->picture_path == ''))
                                <img class="row rounded-circle" align="center" style="margin-top: 0px;margin-left: 5px"
                                     src="{{asset('storage/male.png')}}" width="40px" height="40px">
                            @else
                                <img class="row rounded-circle" align="center"
                                     style=";margin-left: 20px;margin-right: 5px;margin-top: 5px;"
                                     src="../../public/images/{{Auth::user()->picture_path}}" width="40px"
                                     {{--src="{{Auth::user()->picture_path}}" width="120px"--}}
                                     height="40px">
                            @endIf
                            <textarea class="form-control" name="body" id="new-post" rows="5"
                                      placeholder="Your post"
                                      style="border-color: transparent; margin-top: 5px;margin-right: 5px;"

                            ></textarea>
                        </div>
                        <hr style="margin-right: 10px;margin-left: 10px">
                        <div style="display: flex;justify-content: space-around; margin-bottom: 5px">
                            <button type="submit" class="btn btn-secondary">Create post</button>
                            <button type="button" class="btn btn-secondary" data-toggle="modal"
                                    data-target="#edit-modal">Create image post
                            </button>

                        </div>
                        <input type="hidden" value="{{ Session::token() }}" name="_token">
                    </form>
                </div>
            </div>
        </section>
        <section class="row posts " style="margin-top: 15px">
            <div class="col-md-offset-3" style="margin-left: auto;margin-right: auto;width: 60%">
                @foreach($posts as $post)
                    <div class="card"
                         style="margin-top: 10px;margin-right:auto;margin-left: auto;border-width: 1px;border-color: gray;width: 100%">
                        <article class="post" data-postid="{{ $post->id }} "
                                 style="margin-left: 10px;margin-right: 10px">
                            <div style="display:flex;flex-direction: row">
                                @if ((Auth::user()->picture_path == ''))
                                    <img class="row rounded-circle" align="center"
                                         style="margin-top: 0px;margin-left: 5px"
                                         src="{{asset('storage/male.png')}}" width="40px" height="40px">
                                @else
                                    <img class="row rounded-circle" align="center"
                                         style=";margin-left: 0px;margin-right: 5px;margin-top: 5px;"
                                         src="../../public/images/{{Auth::user()->picture_path}}" width="40px"
                                         {{--src="{{Auth::user()->picture_path}}" width="120px"--}}
                                         height="40px">
                                @endIf
                                <div>
                                    <span style="color:mediumblue;font-weight: bold">{{Auth::user()->name}}</span>
                                    <div class="info">
                                        Posted by {{ $post->user['name'] }}
                                        on {{ $post->created_at->format('m/d/Y') }}
                                    </div>
                                </div>
                            </div>

                            <p style="margin-top: 5px">{{ $post->body }} </p>
                            <img class="row" align="center"
                                 style=";margin-left: 0px;margin-right: 5px;margin-top: 5px;width: 100%;height: 100%"
                                 src="../../public/images/{{$post->image}}" width="120px"
                                 height="120px">
                            <hr>
                            <div style="display: flex;flex-direction: row;margin-bottom: 10px">
                                {{--<a href="" style="flex: 1;text-align: center;color: gray">Like</a>--}}
                                <p style="flex: 1;text-align: center;" class="likeBtn">
                                    <a href="" style="color: gray">
                                        <i class="fa fa-thumbs-up"></i>
                                        Like
                                    </a>
                                </p>
                                <p style="flex: 1;text-align: center">
                                    <a href="" style="color: gray">
                                        <i class="fa fa-comment"></i>
                                        Comment
                                    </a>
                                    {{--@if(Auth::user() == $post->user)--}}
                                    {{--<a href="" class="edit" style="color: gray">Edit</a> |--}}
                                    {{--<a href="{{ route('post.delete',['post_id' => $post->id]) }}"--}}
                                    {{--style="color: gray">Delete</a>--}}
                                    {{--@endif--}}
                                </p>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </section>

        <div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title">Post with image</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <form class="col-sm-12 col-md-12" style="margin-top: 10px" action="{{route('createPostImage')}}"
                          method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div>
                                <div class="form-group" style="display: flex;flex-direction: row">
                                    @if ((Auth::user()->picture_path == ''))
                                        <img class="row rounded-circle" align="center"
                                             style="margin-top: 0px;margin-left: 5px"
                                             src="{{asset('storage/male.png')}}" width="40px" height="40px">
                                    @else
                                        <img class="row rounded-circle" align="center"
                                             style=";margin-left: 20px;margin-right: 5px;margin-top: 5px;"
                                             src="../../public/images/{{Auth::user()->picture_path}}" width="40px"
                                             {{--src="{{Auth::user()->picture_path}}" width="120px"--}}
                                             height="40px">
                                    @endIf
                                    <textarea class="form-control" name="body" id="new-post" rows="5"
                                              placeholder="Your post"
                                              style="border-color: transparent; margin-top: 5px;margin-right: 5px;"
                                    ></textarea>
                                </div>
                            </div>
                            <hr>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="file" name="pic_post" class="form-control-file" id="postWithPicture">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="modal-save">Share
                            </button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>

    <script>
        var token = '{{ Session::token() }}';
        var urlEdit = '{{ route('edit') }}';
    </script>
@endsection