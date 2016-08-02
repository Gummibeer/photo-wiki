<li class="dropdown">
    <a href="#" data-toggle="dropdown" class="dropdown-toggle">
        <i class="icon wh-bell"></i>
        @if(\Auth::user()->countUnreadNotifications())
            <span class="indicator"></span>
        @endif
    </a>
    <ul class="dropdown-menu am-notifications">
        <li>
            <div class="title">Notifications<span class="badge">{{ \Auth::user()->countUnreadNotifications() }}</span></div>
            <div class="list">
                <div class="am-scroller nano">
                    <div class="content nano-content">
                        <ul id="notifications-list">
                            @foreach(\Auth::user()->getNotifications(50) as $notification)
                                @define $style = \Datamap::getNotificationStyleByCategory($notification->category->name)
                                <li class="@if(!$notification->read) active @endif notification-{{ $style['style'] }}">
                                    <a href="{{ route('app.get.user.read-notification', $notification->getKey()) }}">
                                        <div class="logo">
                                            <i class="icon {{ $style['icon'] }}"></i>
                                        </div>
                                        <div class="user-content">
                                            @if(!$notification->read)
                                                <span class="circle"></span>
                                            @endif
                                            <span class="text-content">
                                                {{ $notification->text }}
                                            </span>
                                            <span class="date">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer">
                <a href="{{ route('app.get.user.read-notification') }}">
                    {{ __('als gelesen markieren') }}
                </a>
            </div>
        </li>
    </ul>
</li>