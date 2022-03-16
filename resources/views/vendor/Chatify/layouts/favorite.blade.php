<div class="favorite-list-item">
    {{--    <div data-id="{{ $user->id }}" data-action="0" class="avatar av-m"--}}
    {{--         style="background-image: url('{{ asset('/storage/'.config('chatify.user_avatar.folder').'/'.$user->avatar) }}');">--}}


    @if($user->avatar == null)
        <div data-id="{{ $user->id }}" data-action="0" class="avatar av-m">

            <img src="{{asset("img/Tab/user.png")}}"
                 class="avatar avatar w-10 h-10 p-2"
                 alt="default"
            />
        </div>
    @else
        <div data-id="{{ $user->id }}" data-action="0" class="avatar av-m">
            <img src="{{asset("storage/". $user->avatar)}}" class="avatar avatar w-10 h-10" alt="pic">
        </div>
    @endif
    {{--</div>--}}
    <p>{{ strlen($user->name) > 5 ? substr($user->name,0,6).'..' : $user->name }}</p>
</div>
