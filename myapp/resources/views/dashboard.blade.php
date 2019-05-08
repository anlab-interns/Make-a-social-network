{{--Kế thừa giao diện file app.blade.php--}}

@extends('layouts.app')
@section('title')
    My Dashboard
@endsection
@include('includes.message-block')
@section('content')
    <div class="container row justify-content-center"
         style="justify-content: center; align-content: center;margin: auto"
         xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
        @include('includes.sidebar')
        <div class="col-md-6">
            <section class="row new-post">
                <div class="card" style="margin: auto;border-width: 1px;border-color: gray;width: 90%">
                    <div class="card-header">What do you think?</div>
                    <div>
                        <form v-on:submit.prevent="addPost" enctype="multipart/form-data" method="post">
                            <div class="form-group" style="display: flex;flex-direction: row">
                                @if ((Auth::user()->picture_path == ''))
                                    <img class="row rounded-circle" align="center"
                                         style="margin-top: 5px;margin-right: 5px;margin-left: 5px"
                                         src="{{asset('storage/male.png')}}" width="40px" height="40px">
                                @else
                                    <img class="row rounded-circle" align="center"
                                         style=";margin-left: 20px;margin-right: 5px;margin-top: 5px;"
                                         src="../../public/images/{{Auth::user()->picture_path}}" width="40px"
                                         {{--src="{{Auth::user()->picture_path}}" width="120px"--}}
                                         height="40px">
                                @endIf
                                <textarea class="form-control" v-model="body" name="body" id="new-post" rows="5"
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
                <div class="col-md-offset-3" style="margin-left: auto;margin-right: auto;width: 90%">
                    <div class="card"
                         v-for="post,key in posts"
                         style="margin-top: 10px;margin-right:auto;margin-left: auto;border-width: 1px;border-color: gray;width: 100%">
                        <article
                                class="post"
                                data-postid="post.id"
                                style="margin-left: 10px;margin-right: 10px">
                            <div style="display:flex;flex-direction: row">
                                <img v-if="getImgUrl(post.user.picture_path) == ''" class="row rounded-circle"
                                     align="center"
                                     style="margin-top: 5px;margin-right: 5px;margin-left: 5px"
                                     src="{{asset('storage/male.png')}}" width="40px" height="40px">
                                <img v-else class="row rounded-circle" align="center"
                                     style=";margin-left: 0px;margin-right: 5px;margin-top: 5px;"
                                     :src="getImgUrl(post.user.picture_path)" width="40px"
                                     height="40px">
                                <div>
                                    <span style="color:mediumblue;font-weight: bold">@{{post.user['name']}}</span>
                                    <div class="info">
                                        on @{{post.created_at}}
                                    </div>
                                </div>
                            </div>

                            <p style="margin-top: 5px">@{{post.body}} </p>
                            <img v-if="post.image!=null" class="row" align="center"
                                 style=";margin-left: 0px;margin-right: 5px;margin-top: 5px;width: 100%;height: 100%"
                                 :src="getImgUrl(post.image)" width="120px"
                                 height="120px">
                            <hr>
                            <div style="display: flex;flex-direction: row;margin-bottom: 10px;border-bottom:1px solid #ddd">
                                <a href="#" v-if="post.likes.length!=0" style="flex: 1;text-align: center;color: gray">
                                    <i class="fa fa-thumbs-up" style="color: blue;"></i>
                                    Thích
                                    <b style="color: green">@{{ post.likes.length }}</b>
                                </a>
                                <a href="#" v-else class="likeBtn" @click="likePost(post.id)"
                                   style="flex: 1;text-align: center;color: gray">
                                    <i class="fa fa-thumbs-up"></i>
                                    Thích
                                </a>

                                <p style="flex: 1;text-align: center;">
                                    <a href="#" @click="toggle(key)" style="color: gray">
                                        <i class="fa fa-comment"></i>
                                        Comment <b style="color: green">@{{post.comments.length}}</b>
                                    </a>
                                    {{--                                    <a href="#" class="edit" style="color: gray" @click="populate">Edit</a> |--}}
                                    <a v-if="post.user_id=={{Auth::user()->id}}"
                                       href="#"
                                       @click="deletePost(post.id); deleteLike(post.id)"
                                       style="color: gray">Delete</a>
                                </p>
                            </div>
                            <div v-if="showComment==key && index==true"
                                 style="background-color:#F6F7F9;width:99%;margin:0 auto">
                                <div style="padding: 10px;margin-bottom: 10px">
                                <textarea placeholder="Your comment"
                                          v-model="commentData[key]"
                                          style="width: 99%; margin-top: 5px;margin-right: 5px;"></textarea>
                                    <button class="btn-success" @click="addComment(post,key)" style="margin-top: 10px">
                                        Comment
                                    </button>
                                </div>
                                <div v-for="comment in post.comments"
                                     style="list-style: none;margin-left: 20px;margin-bottom: 10px">
                                    <div v-for="user in allUsers" style="display: flex;flex-direction: row">
                                        <img v-if="getImgUrl(user.picture_path) == '' && user.id == comment.user_id"
                                             class="row rounded-circle"
                                             align="center"
                                             style="margin-top: 5px;margin-right: 5px;margin-left: 5px"
                                             src="{{asset('storage/male.png')}}" width="40px" height="40px">
                                        <img v-if="user.id == comment.user_id" class="row rounded-circle" align="center"
                                             style=";margin-left: 0px;margin-right: 5px;margin-top: 5px;"
                                             :src="getImgUrl(user.picture_path)" width="40px"
                                             height="40px">
                                        <p v-if="user.id == comment.user_id"
                                           style="font-weight: bold;color: blue;margin-left: 5px;margin-top: 11px;margin-bottom:11px;text-align: center">
                                            @{{
                                            user['name']
                                            }}</p>
                                        <div v-if="user.id == comment.user_id"
                                             style="padding:10px"
                                        >@{{ comment.comment }}
                                        </div>
                                    </div>
                                    <p style="margin:auto;width: 82%;color: #8ab2f2">@{{ post.created_at }}</p>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </section>
        </div>

        <div class="align-content-center">
            <ul v-for="friend in friends" class="list-group">
                <div class="list-group-item "
                     style="display: flex;flex-direction: row">
                    <a href="#" @click="getFriendInbox(friend);displayInboxWindow()" style="display: block;">
                        <div>
                            <img v-if="friend.picture_path == ''" class="row rounded-circle" align="center"
                                 style="margin-top: 0px;margin-right: 5px;margin-left: 5px"
                                 src="{{asset('storage/male.png')}}" width="30px" height="30px">
                            <img v-else class="row rounded-circle" align="center"
                                 style="margin-top: 0px;margin-right: 5px;margin-left: 5px;"
                                 :src="getImgUrl(friend.picture_path)" width="30px"
                                 height="30px">
                        </div>
                        <div>
                            <p style="margin: auto">
                                <a href="#"
                                   style="color: black">@{{(friend.name)}}</a>
                            </p>
                        </div>
                    </a>
                </div>
            </ul>
        </div>
        <div v-if="friendInbox != null" v-bind:style="{visibility: inboxWindowVisibility}" class="card" style="margin: auto;position: absolute;
                            z-index: 1;
                            bottom: 9px;
                            right: 10px;border-width: 1px;border-color: gray;width: 15%;height: 30%">
            <div class="row">
                <img v-if="friendInbox.picture_path == ''" class="row rounded-circle" align="center"
                     style="margin-top: 5px;margin-right: 5px;margin-left: 20px"
                     src="{{asset('storage/male.png')}}" width="40px" height="40px">
                <img v-else class="row rounded-circle" align="center"
                     style=";margin-left: 20px;margin-right: 5px;margin-top: 5px;"
                     :src="getImgUrl(friendInbox.picture_path)" width="40px"
                     height="40px">
                <p style="font-weight: bold">@{{friendInbox.name}}</p>
            </div>
            <div class="card-body">
                <chat-box v-bind:receiver_id="friendInbox.id"></chat-box>
            </div>
        </div>
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
                                             style="margin-top: 0px;margin-right: 5px;margin-left: 5px"
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
@endsection