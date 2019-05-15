<div class="align-content-center col-md-2">
    <ul class="list-group">
        <li class="list-group-item"><a href="{{route('dashboard')}}">Home</a></li>
        <li class="list-group-item"><a href="{{url('/profile')}}/{{Auth::user()->name}}">Profile</a></li>
        <li class="list-group-item"><a href="{{route('findFriend') }}">
                Find Friend
            </a></li>
        <li class="list-group-item"><a href="{{route('friends') }}">
                Friend
            </a></li>
        <li class="list-group-item"><a href="{{route('chat') }}">
                Conversation
            </a></li>
        <li class="list-group-item"><a href="{{route('requests') }}">
                My Request
                <span style="color: green; font-weight: bold;">({{App\Http\Controllers\FriendController::requestCount()}})</span>
            </a></li>
    </ul>
</div>